<?php

namespace Tests\Feature;

use App\User;
use Artisan;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_valid_token_can_access_a_protected_resource()
    {
        HelperFunctions::createTestPersonalAccessClient();
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token', ['user'])->accessToken;


        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', '/home')
            ->assertStatus(200);
    }

    /** @test */
    public function a_revoked_token_cannot_access_a_protected_resource()
    {
        HelperFunctions::createTestPersonalAccessClient();
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token', ['user']);


        $tokenRepository = app('Laravel\Passport\TokenRepository');
        // Revoke an access token...
        $tokenRepository->revokeAccessToken($token->token->id);

        self::assertTrue($tokenRepository->isAccessTokenRevoked($token->token->id));
        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('get', '/home')
            ->assertStatus(401);
    }

    /** @test */
    public function a_token_with_invalid_scope_cannot_access_a_protected_resource()
    {
        HelperFunctions::createTestPersonalAccessClient();
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token');

        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('get', '/home')
            ->assertStatus(403);
    }

    /** @test */
    public function an_external_client_can_get_a_valid_client_access_token()
    {
        $passportClient = HelperFunctions::createTestClientCredentialsClient();
        $guzzleClient = new Client();


        $params = [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'create-users',
                'client_id' => $passportClient->id,
                'client_secret' => $passportClient->secret
            ],
        ];
//        $token = $this->withHeaders($params)->post('/oauth/token');
        $response = $guzzleClient->post('http://localhost/oauth/token', $params);
        self::assertJson($response->getBody());
        $token = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR)['access_token'];

        $this->assertStringStartsWith("eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.", $token);
    }
}

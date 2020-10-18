<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    private $client;

    public function setUp() : void
    {
        parent::setUp();
        $this->createClient();
    }

    /** @test */
    public function a_valid_token_can_access_a_protected_resource()
    {
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token')->accessToken;


        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', '/home')
            ->assertStatus(200);
    }

    /** @test */
    public function an_invalid_token_cannot_access_a_protected_resource()
    {
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token');

        $tokenRepository = app('Laravel\Passport\TokenRepository');
        // Revoke an access token...
        $tokenRepository->revokeAccessToken($token->token->id);

        self::assertTrue($tokenRepository->isAccessTokenRevoked($token->token->id));
        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('get', '/home')
            ->assertStatus(401);
    }

    private function createClient() : void
    {
        $clientRepository = new ClientRepository();
        $this->client = $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insertOrIgnore([
            'client_id'  => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        $clientSecret = 'smRCHamQGXSIec8MqBHQHKcASW7NcxA0Z8w4qmlQ';
        $client->setSecretAttribute($clientSecret);
        $client->save();
    }
}

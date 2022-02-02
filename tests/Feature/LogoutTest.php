<?php

namespace Tests\Feature;

use App\User;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_logout()
    {
        $this->withoutExceptionHandling();
        $client = HelperFunctions::createTestPersonalAccessClient();
        $user = User::factory()->create();

        $token = $user->createToken('Personal Access Token', ['user']);

        $attributes = [
            'id' => $token->token->id,
            'user_id' => '1',
            'client_id' => '1',
            'name' => 'Personal Access Token',
            'revoked' => '0',
            'created_at' => $token->token->created_at,
            'updated_at' => $token->token->updated_at,
            'expires_at' => $token->token->expires_at,

        ];
        $this->assertDatabaseHas('oauth_access_tokens', $attributes);

        $tokenRepository = app('Laravel\Passport\TokenRepository');

        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('post', '/logout')
            ->assertStatus(204);

        self::assertTrue($tokenRepository->isAccessTokenRevoked($token->token->id));


        $this->assertDatabaseMissing('oauth_access_tokens', $attributes);
    }

    /** @test */
    public function a_logged_out_user_cannot_access_a_protected_resource()
    {
        $this->withoutExceptionHandling();
        HelperFunctions::createTestPersonalAccessClient();
        $user = User::factory()->create();
        $tokenResult = $user->createToken('Personal Access Token', ['user']);
        $token = $tokenResult->token;

        $attributes = [
            'id' => $token->id,
            'user_id' => '1',
            'client_id' => '1',
            'name' => 'Personal Access Token',
            'revoked' => '0',
            'created_at' => $token->created_at,
            'updated_at' => $token->updated_at,
            'expires_at' => $token->expires_at,

        ];
        $this->assertDatabaseHas('oauth_access_tokens', $attributes);

        $this->withHeader('Authorization', 'Bearer ' . $tokenResult->accessToken)
            ->json('get', '/api/home')
            ->assertStatus(200);

        $this->withHeader('Authorization', 'Bearer ' . $tokenResult->accessToken)
            ->json('post', 'logout')
            ->assertStatus(204);

        $tokenRepository = app('Laravel\Passport\TokenRepository');



        self::assertTrue($tokenRepository->isAccessTokenRevoked($token->id));

        $attributes = [
            'id' => $token->id,
            'user_id' => '1',
            'client_id' => '1',
            'name' => 'Personal Access Token',
            'revoked' => '0',
            'created_at' => $token->created_at,
            'updated_at' => $token->updated_at,
            'expires_at' => $token->expires_at,

        ];
        $this->assertDatabaseMissing('oauth_access_tokens', $attributes);

        $this->withHeader('Authorization', 'Bearer ' . $tokenResult->accessToken)
            ->json('get', '/api/test')
            ->assertStatus(401);
    }
}

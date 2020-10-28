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
        $client = HelperFunctions::createTestClient();
        $user = User::factory()->create();

        $token = $user->createToken('Personal Access Token', ['login']);

        $attributes = [
            'id' => $token->token->id,
            'user_id' => '1',
            'client_id' => '1',
            'name' => 'Personal Access Token',
            'scopes' => "[\"login\"]",
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
        HelperFunctions::createTestClient();
        $user = User::factory()->create();
        $token = $user->createToken('Personal Access Token', ['login']);

        $tokenRepository = app('Laravel\Passport\TokenRepository');

        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('post', 'logout')
            ->assertStatus(204);

        self::assertTrue($tokenRepository->isAccessTokenRevoked($token->token->id));

        $this->withHeader('Authorization', 'Bearer ' . $token->accessToken)
            ->json('get', '/home')
            ->assertStatus(401);
    }
}

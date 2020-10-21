<?php

namespace Tests\Feature;

use App\User;
use DateTime;
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
        HelperFunctions::createTestClient();
        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token')->accessToken;


        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', '/home')
            ->assertStatus(200);
    }

    /** @test */
    public function an_invalid_token_cannot_access_a_protected_resource()
    {
        HelperFunctions::createTestClient();
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
}

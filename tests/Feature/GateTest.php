<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class GateTest extends TestCase
{
    use RefreshDatabase;


    private $client;

    /** @test */
    public function a_logged_in_user_is_allowed_gated_access_to_a_protected_resource()
    {
        HelperFunctions::createTestPersonalAccessClient();

        $user = User::factory()->create();
        $token= $user->createToken('Personal Access Token', ['user'])->accessToken;
        $user->actingAsLoggedIn();
        self::assertTrue($user->isLoggedIn());

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', '/home')
            ->assertStatus(200);
    }
}

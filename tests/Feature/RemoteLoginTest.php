<?php

namespace Tests\Feature;
session_start();
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoteLoginTest extends TestCase
{
    /** @test */
    public function an_authorized_user_can_login()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/login');

        $response->assertStatus(200)->assertSee($_SESSION['state']);

        //Listen to login channel->Wait for login broadcast

        //"Scan" the code
    }
}

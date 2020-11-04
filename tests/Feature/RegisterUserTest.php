<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_uploaded_to_server_from_remote_client()
    {
        $this->withoutExceptionHandling();
        $passportClient = HelperFunctions::createTestClientCredentialsClient();

        $guzzleClient = new Client();
        $secret = $passportClient->getPlainSecretAttribute();
        $result = DB::select("select * from oauth_clients");
        $params = [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => '',
                'client_id' => $passportClient->id,
                'client_secret' => $secret
            ],
        ];
//        $token = $this->withHeaders($params)->post('/oauth/token');
        $response = $guzzleClient->post('http://localhost/oauth/token', $params);
        $token = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR)['access_token'];

        self::assertJson($token);
    }
}

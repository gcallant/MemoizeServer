<?php

namespace Tests\Feature\Remote;

use App\User;
use Clef\Clef;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;
use function MongoDB\BSON\toJSON;

class RegisterUserTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function a_user_can_be_uploaded_to_server_from_remote_client()
    {
        $user = User::factory()->make();
        list($privateKey, $publicKey) = HelperFunctions::createKeypair();
        $user->public_key = $publicKey;
        $userAttributes = HelperFunctions::getUserAsArray($user);

        //We're only using this as a convenient way to pull in REAL client info from the DB
        //This allows us to only have to update the method once when the client info changes
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

        self::assertEquals(200, $response->getStatusCode());

        $token = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR)['access_token'];

        //Insert token into test DB-> because it checks against test DB
        //but Guzzle connection to server inserts into prod DB
        HelperFunctions::saveTestToken($token, $passportClient->id);


        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/user', $userAttributes)
            ->assertStatus(200);

    }
}

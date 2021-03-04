<?php

namespace Tests\Feature;

use App\Events\LoginAuthorized;
use App\Http\Controllers\Auth\LoginController;
use App\User;
use Cache;
use Clef\Clef;
use Clef\Signing;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_be_authenticated()
    {
        HelperFunctions::createTestPersonalAccessClient();
        Cache::spy();
        Event::fake();

        $user = User::factory()->create();
        list($privateKey, $publicKey) = HelperFunctions::createKeypair();

        Clef::configure(array(
            "id" => 6,
            "secret" => "sdfw34sefasdf2q34rsadfsdf",
            "keypair" => $privateKey,
            "passphrase" => ""));

        $user->public_key = $publicKey["key"];
        $user->save();
        $random_id = $this->get('/api/randomBytes')->content();
        $ttl = 60;



        $signedPayload = Clef::sign_login_payload(array(
            "nonce" => bin2hex(openssl_random_pseudo_bytes(16)),
            "user_id" => $user->id,
            "redirect_url" => '',
            "random_id" => $random_id));

        $encodedPayload = Clef::encode_payload($signedPayload);

        $payload = ["payload" => $encodedPayload];

//        $encodedPayload = [
//            "payload" => "eyJwYXlsb2FkX2pzb24iOiJleUoxYzJWeVgybGtJam9pVDNCMGFXOXVZV3dvTkNraUxDSnlZVzVrYjIxZmFXUWlPaUpqWmpJMFZDMXRRMW8yY21wVk1sTmFXRGhOTTFVNGVsRkRaVkpxYm1NdFpEbDVWVXBmV1RSUmNGQnFXREkzTVZOSFIwNVBSelJzZG05aVgwTmpXbGxIWm1WTlFXWnRjVlZzVEVVNU4xWjZabGd3TWtNNWR5d3NJbjA9Iiwic2lnbmF0dXJlcyI6eyJ1c2VyIjp7InR5cGUiOiJlY2RzYS1zaGE1MTIiLCJzaWduYXR1cmUiOiIwRlx1MDAwMiFcdTAwMDDvv73vv73vv71Ode+/ve+/vXUk77+977+977+9Y0Hvv73vv73vv71oYu+/vTxcdTAwMTBTTEbvv73vv71LNS5cdTAwMDIhXHUwMDAw77+9XHUwMDE277+9XHUwMDBm77+977+977+9XHUwMDFl77+9XHUwMDFjXHUwMDA27p2p77+9XHUwMDEz77+977+977+9Tu+/vVwvV++/vcem77+9U1x1MDAxM++/ve+/ve+/vSJ9fSwicGF5bG9hZF9oYXNoIjoiNERGNEVGOUVBMjU0QUQ4OEJEMEJGQUJDNTE4ODg0NEI2ODA2QzE0RkE0REIxRTJCQkRBQTJFQjUxQzQ4Q0JCNzIwODdBNzVDQjAzOEM5QTFFQzRBQzE0MEQ5RDNCNTY3MjVBQzI2NDJDNjI5MDNBQkI3Qjc5MkE2MTQ3NUQ4NUQifQ=="
//        ];

        $this->postJson("/api/login", $payload)->assertStatus(200)
             ->assertOk();

        Event::assertDispatched(LoginAuthorized::class);
        //Cache::shouldHaveReceived('put')->once()->with($random_id, $user->id, $ttl);

//            ->assertJsonStructure([
//                "access_token",
//                "token_type",
//                "expires_at"
//            ]);
    }

    /** @test */
    public function a_hash_should_be_consistent_across_platforms()
    {
        Clef::configure(array(
            "id" => 6,
            "secret" => "sdfw34sefasdf2q34rsadfsdf",
            "keypair" => "",
            "passphrase" => ""));

        $payloadJson = "eyJ1c2VyX2lkIjoiT3B0aW9uYWwoNCkiLCJyYW5kb21faWQiOiJSeDdyYjNVbWNVNzZSN1VaakFpQ2ZhMkNiVHpFTXZoUjQtSEJQWE9IeU9YaGdWd0U2MmlPNTlxekxwTS1DX3lOOGM5Vkp1RkhfM0hQU3FaNXNCWFVjUSwsIn0=";
        $payloadHash = "043f0c77722c52f4de3f24e11dbcbd4b3138cfeaff41244046960ab6624101bc1ee774b105b5c8823d0d27047437429c88f7ea54ef130d6fdf627f2c82b56316";
        $encodedPayload = [
            "payload" => "eyJwYXlsb2FkX2pzb24iOiJleUoxYzJWeVgybGtJam9pTmlJc0luSmhibVJ2YlY5cFpDSTZJamcyT1ZFMGNIbGZhMVV0VDNBNWVIQTNkQzFYWWtOblNXSkVTelZJTTFaT1FuTnNhamhQVTJoQ09HNTRRakYyWlVKeGNEQldZMWgyYjBoWWJrRkpRVzVuY2xCTE5rZHBYMU5KTFhKWmRsZ3hTbmwzY0VGQkxDd2lmUT09Iiwic2lnbmF0dXJlcyI6eyJ1c2VyIjp7InR5cGUiOiJlY2RzYS1zaGE1MTIiLCJzaWduYXR1cmUiOiJNRVVDSURVaXFqZ3RXRjY4akRZSVAralBuQmtUSVl1clk5NldcL1JmdG5RaFd6N1Q1QWlFQWlCaVUxN05LQzZTakNJNVJtcjdvVGN4SzFSaXpoc0Q3RlpINHJadkZlWEU9In19LCJwYXlsb2FkX2hhc2giOiI0ZDcwNmE5OGExMzExZmZjMjI4NzgxMTJmYjBmN2FlM2Q3MzMxNWRjZDNiZTlhODQzOTg2MmI5ZDI4MzY1ZDg3ZTQ5YTE0MjViZDdlYmM0MTU3YTI5YWM2MjllMTJmNWJiYjI2MDVhNGE0MzY0OTlmM2M0MGQyOGI1MGViNWE4ZSJ9"
        ];
        $payload = Clef::decode_payload($encodedPayload['payload']);

        $hash1 = hash("sha512", base64_decode($payloadJson), false);



        $hash2 = openssl_digest(base64_decode($payloadJson), "sha512", false);
        $this->assertEquals($hash1, $hash2);

        $this->assertEquals($payloadHash, $hash1);
        $key = [0x30, 0x59, 0x30, 0x13, 0x06, 0x07, 0x2A, 0x86, 0x48, 0xCE, 0x3D, 0x02, 0x01, 0x06, 0x08, 0x2A, 0x86, 0x48, 0xCE, 0x3D, 0x03, 0x01, 0x07, 0x03, 0x42, 0x00];
        $data = base64_decode("BIcbD//No8vZ2JZ5IKGICl4XGxcn0rOCTCf52JCkyxOzYEM8drYZlWBGnJC4KwM7foGfUVYcwfld75n3wmJQ9Qw=");
        $key[] = $data;
        Clef::verify_login_payload($payload, "-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEf16tnH8YPjslaacdtdde4wRQs0PP
zj/nWgBC/JY5aeajHhbKAf75t6Umz6vFGBsdgM/AFMkeB4n2Qi96ePNjFg==
-----END PUBLIC KEY-----");
    }

    /** @test */
    public function a_valid_payload_can_be_decoded()
    {
        $this->withoutExceptionHandling();

        Clef::configure(array(
            "id" => 6,
            "secret" => "sdfw34sefasdf2q34rsadfsdf",
            "keypair" => "",
            "passphrase" => ""));

        $payload = [
            "payload" => "eyJwYXlsb2FkX2pzb24iOiJleUoxYzJWeVgybGtJam9pTmlJc0luSmhibVJ2YlY5cFpDSTZJbk5RYjBWNlEzbHFVMVUyTlRoVGVYbEdSVUV4VkdSUFNHaEdhSEE1WmkxaGJFSkZhalJWZUV4VFZIUkJUV2RqUWtONk16ZDFlVnAyVFc1amN6WnhNRU0xYlRkcU1HSlZhR0ZUTlRKSlpEUldjbXhKWm5CM0xDd2lmUT09Iiwic2lnbmF0dXJlcyI6eyJ1c2VyIjp7InR5cGUiOiJlY2RzYS1zaGE1MTIiLCJzaWduYXR1cmUiOiJNRVVDSVFEaXhoZzh3UTl5WnUzUnN3UkE1MEZ0VGszdndvdXhEY3h4YURcL3ByMjJaeUFJZ1NKeVpLSStBMmh6VWNUUTBkTklhNE1aN2ZhMXRpWTFNMG5zZWZzdlU5cGc9In19LCJwYXlsb2FkX2hhc2giOiIwYTc1MmE2MWJmNmU4OGVmZmZhNDk2YmU4Mzk1YWZiN2EwNmQzNmZhYzgwYzRhNDAxMzcwMjVkMzAyZDhmN2JjIn0="
        ];

        $this->postJson("/api/login", $payload)->assertStatus(200)
            ->assertOk();
    }

    /** @test */
    public function an_authenticated_user_can_access_a_protected_resource()
    {
        $this->withoutExceptionHandling();
        HelperFunctions::createTestPersonalAccessClient();

        $user = User::factory()->create();
        list($privateKey, $publicKey) = HelperFunctions::createKeypair();
        $user->public_key = $publicKey["key"];
        $user->save();

        Clef::configure(array(
            "id" => 6,
            "secret" => "sdfw34sefasdf2q34rsadfsdf",
            "keypair" => $privateKey,
            "passphrase" => ""));

        $signedPayload = Clef::sign_login_payload(array(
            "nonce" => bin2hex(openssl_random_pseudo_bytes(16)),
            "clef_id" => $user->id,
            "redirect_url" => '',
            "session_id" => session_id()));

        $encodedPayload = [
            "payload" => Clef::encode_payload($signedPayload)
        ];

        $token = $this->postJson("/login", $encodedPayload)->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_at"
            ]);
        $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])
            ->json('get', '/home')->assertStatus(200);
    }

    /** @test */
    public function an_unauthorized_user_cannot_be_authenticated()
    {
        HelperFunctions::createTestPersonalAccessClient();

        $user = User::factory()->create();
        list($privateKey, $publicKey) = HelperFunctions::createKeypair();
        $user->public_key = $publicKey["key"];
        $user->save();
        list($wrongPrivateKey, $wrongPublicKey) = HelperFunctions::createKeypair();
        Clef::configure(array(
            "id" => 6,
            "secret" => "sdfw34sefasdf2q34rsadfsdf",
            "keypair" => $wrongPrivateKey,
            "passphrase" => ""));

        $signedPayload = Clef::sign_login_payload(array(
            "nonce" => bin2hex(openssl_random_pseudo_bytes(16)),
            "clef_id" => $user->id,
            "redirect_url" => '',
            "session_id" => session_id()));

        $encodedPayload = [
            "payload" => Clef::encode_payload($signedPayload)
        ];

        $this->postJson("/login", $encodedPayload)->assertStatus(401);
    }
}

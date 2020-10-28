<?php

namespace Tests\Feature;

use App\User;
use Clef\Clef;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\Helpers\HelperFunctions;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_be_authenticated()
    {
        HelperFunctions::createTestClient();

        $user = User::factory()->create();
        list($privateKey, $publicKey) = $this->createKeypair();
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

        $this->postJson("/login", $encodedPayload)->assertStatus(200)
        ->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_at"
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_be_authenticated()
    {
        HelperFunctions::createTestClient();

        $user = User::factory()->create();
        list($privateKey, $publicKey) = $this->createKeypair();
        $user->public_key = $publicKey["key"];
        $user->save();
        list($wrongPrivateKey, $wrongPublicKey) = $this->createKeypair();
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

    /**
     * @return array
     */
    private function createKeypair() : array
    {
        $configargs = array(
            "config"           => "C:\php\openssl.cfg",
            "digest_alg"       => "sha512",
            "curve_name"       => "prime256v1",
            "private_key_type" => OPENSSL_KEYTYPE_EC
        );
        $privateKey = null;
        $newKey = openssl_pkey_new($configargs);
        openssl_pkey_export($newKey, $privateKey, null, $configargs);
        $publicKey = openssl_pkey_get_details($newKey);

        return array($privateKey, $publicKey);
    }
}

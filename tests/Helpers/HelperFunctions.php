<?php


namespace Tests\Helpers;


use App\User;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class HelperFunctions
{

    public static function createTestPersonalAccessClient() : Client
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
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

        return $client;
    }

    public static function createTestClientCredentialsClient() : Client
    {
        //Artisan::call('passport:install');

        $clientRepository = new ClientRepository();
        $client = $clientRepository->create(
            null, 'Test Credentials Client','http://localhost', 'users', false, false);

        DB::table('oauth_clients')->insertOrIgnore([
            'id'  => $client->id,
            'name' => $client->name,
            'secret' => $client->secret,
            'personal_access_client' => false,
            'password_client' => false,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        //For most tests this HAS to be a REAL client that already exists in the DB
        //Since any external requests will be hitting the actual server DB
        $clientSecret = 'H7S47mZTmsh3k9gi6kKCfv03mF0a4FXVEJwe7vLG';
        $client->setSecretAttribute($clientSecret);
        $client->save();
        return $client;
    }

    public static function saveTestToken(string $token, int $clientId) : void
    {
        $passportPublicKey = file_get_contents(storage_path('oauth-public.key'));
        $decodedToken = JWT::decode($token, $passportPublicKey, array('RS256'));

        $attributes = [
            'id' => $decodedToken->jti,
            'client_id' => $clientId,
            'scopes' => $decodedToken->scopes,
            'revoked' => false,
            'created_at' => $decodedToken->nbf,
            'updated_at' => $decodedToken->iat,
            'expires_at' => $decodedToken->exp
        ];

        Passport::token()->create($attributes);
    }



    /**
     * @return array
     */
    public static function createKeypair() : array
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

    public static function getUserAsArray(User $user) : array
    {
        return [
            'id' => 1,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'confirmed' => $user->confirmed,
            'public_key' => $user->public_key['key']
        ];
    }
}

<?php


namespace Tests\Helpers;


use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use DateTime;

class HelperFunctions
{

    public static function createTestClient() : void
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
    }
}

<?php


namespace Tests\Helpers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use DateTime;
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
            null, 'Test Credentials Client','http://localhost');

//        DB::table('oauth_clients')->insertOrIgnore([
//            'id'  => $client->id,
//            'created_at' => new DateTime,
//            'updated_at' => new DateTime,
//        ]);



//        $client = Client::find(3);
//        $clientSecret = 'smRCHamQGXSIec8MqBHQHKcASW7NcxA0Z8w4qmlQ';
//        $client->setSecretAttribute($clientSecret);
//        $client->save();
        return $client;
    }
}

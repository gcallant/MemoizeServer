<?php


namespace App\Guards;


use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\PassportUserProvider;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class CustomRequestGuard extends \Illuminate\Auth\RequestGuard
{
    public function unsetUser()
    {
        $this->user = null;
    }
}

class CustomPassportProvider extends PassportServiceProvider
{
    /**
     * Make an instance of the token guard.
     *
     * @param array $config
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new CustomRequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                new PassportUserProvider(Auth::createUserProvider($config['provider']), $config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }

}

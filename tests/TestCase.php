<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase as BaseTestCase;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;
use DavideCasiraghi\LaravelCards\LaravelCardsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->withFactories(__DIR__.'/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelCardsServiceProvider::class,
            \Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
            \Dimsav\Translatable\TranslatableServiceProvider::class,
            \DavideCasiraghi\LaravelFormPartials\LaravelFormPartialsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelCards' => LaravelCards::class, // facade called PhpResponsiveQuote and the name of the facade class
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
            'LaravelFormPartials' => \DavideCasiraghi\LaravelFormPartials\Facades\LaravelFormPartials::class,
        ];
    }
    
    // Authenticate the user
    public function authenticate()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);
    }

    // Authenticate the admin
    public function authenticateAsAdmin()
    {
        $user = factory(User::class)->make([
                'group' => 2,
            ]);

        $this->actingAs($user);
    }

    // Authenticate the super admin
    public function authenticateAsSuperAdmin()
    {
        $user = factory(User::class)->make([
                'group' => 1,
            ]);

        $this->actingAs($user);
    }

    protected function createUser()
    {
        User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test',
        ]);
    }
}

<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Bootstrap the application and rebuild schema before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // 1) Drop every table in the database
        $schema = $this->app->make('db')->connection()->getSchemaBuilder();
        $schema->dropAllTables();

        // 2) Run only the migrations in database/migrations
        $this->artisan('migrate', [
            '--path' => 'database/migrations',
        ])->run();

        // 3) Reset the Artisan kernel so any further calls still work
        $this->app[Kernel::class]->setArtisan(null);
    }
}

<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase {
        // alias the trait’s method so we can override it
        RefreshDatabase::runDatabaseMigrations as baseRunDatabaseMigrations;
    }
    use CreatesApplication;

    /**
     * Override the trait method so it only runs migrations
     * from your app’s database/migrations folder.
     */
    protected function runDatabaseMigrations(): void
    {
        // drop & re-create all tables, then run only your migrations
        $this->artisan('migrate:fresh', [
            '--path' => 'database/migrations',
        ])->run();

        // reset the Artisan kernel so other commands still work
        $this->app[Kernel::class]->setArtisan(null);
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
abstract class TestCase extends BaseTestCase
{
    protected $defaultHeaders = [
        'X-Inertia' => 'true',
        'Accept'    => 'application/vnd.inertia+json',
    ];

}

<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TJVB\GitLabWebhooks\GitLabWebhooksServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GitLabWebhooksServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        # Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}

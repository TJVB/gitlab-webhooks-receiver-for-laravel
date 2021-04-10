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
}

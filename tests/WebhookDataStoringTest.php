<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use TJVB\GitLabWebhooks\Actions\StoreInComingWebhookRequestData;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use TJVB\GitLabWebhooks\Tests\Fixtures\WebHookRequest;

class WebhookDataStoringTest extends TestCase
{
    /**
     * @test
     */
    public function weStoreTheWebhookData(): void
    {
        $this->markTestIncomplete('TODO');
// setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weGetAnExceptionIfWeHaveInvalidJson(): void
    {
        // setup / mock
        $request = new WebHookRequest();
        $request->content = 'invalid json';

        $this->expectException(InvalidInputException::class);
        // run
        $storing = new StoreInComingWebhookRequestData();
        $storing->handle($request);

        // verify/assert
    }

    /**
     * @test
     */
    public function weSeeTheDifferenceBetweenAnSystemHookAndNormalHook(): void
    {
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weStoreTheObjectKind(): void
    {
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weStoreTheEventData(): void
    {
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
    }

    /**
     * @test
     */
    public function weDispatchTheHookHandling(): void
    {
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
    }
}

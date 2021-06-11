<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use TJVB\GitLabWebhooks\Actions\StoreInComingWebhookRequestData;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use TJVB\GitLabWebhooks\Tests\Fixtures\WebHookRequest;

class WebhookDataStoringTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function weStoreTheWebhookData(): void
    {
        // setup / mock
        $data = json_encode(['testfield' => 'testdata']);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = new StoreInComingWebhookRequestData();
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data]);
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
        // setup / mock
        $data = json_encode(['testfield' => 'testdata']);
        $request = new WebHookRequest();
        $request->content = $data;


        $systemData = json_encode(['testfield' => 'systemdata']);
        $systemRequest = new WebHookRequest();
        $systemRequest->content = $systemData;
        $systemRequest->headers['X-Gitlab-Event'] = 'System Hook';

        // run
        $storing = new StoreInComingWebhookRequestData();
        $storing->handle($request);
        $storing->handle($systemRequest);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data, 'system_hook' => false]);
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $systemData, 'system_hook' => true]);
    }

    /**
     * @test
     */
    public function weStoreTheObjectKind(): void
    {
        // setup / mock
        $objectKind = 'object_kind_' . mt_rand();
        $data = json_encode(['testfield' => 'testdata', 'object_kind' => $objectKind]);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = new StoreInComingWebhookRequestData();
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data, 'object_kind' => $objectKind]);
    }

    /**
     * @test
     */
    public function weStoreTheEventData(): void
    {
        // setup / mock
        $eventType = 'event_type_' . mt_rand();
        $eventName = 'event_name_' . mt_rand();
        $data = json_encode(['testfield' => 'testdata', 'event_type' => $eventType, 'event_name' => $eventName]);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = new StoreInComingWebhookRequestData();
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', [
            'body' => $data,
            'event_type' => $eventType,
            'event_name' => $eventName,
        ]);
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

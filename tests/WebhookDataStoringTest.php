<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use TJVB\GitLabWebhooks\Actions\StoreInComingWebhookRequestData;
use TJVB\GitLabWebhooks\Contracts\Events\GitLabHookStored;
use TJVB\GitLabWebhooks\Events\HookStored;
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
        Event::fake();
        $data = json_encode(['testfield' => 'testdata']);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = $this->app->make(StoreInComingWebhookRequestData::class);
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data]);
        Event::assertDispatched(HookStored::class);
    }

    /**
     * @test
     */
    public function weGetAnExceptionIfWeHaveInvalidJson(): void
    {
        // setup / mock
        Event::fake();
        $request = new WebHookRequest();
        $request->content = 'invalid json';

        $this->expectException(InvalidInputException::class);
        // run
        $storing = $this->app->make(StoreInComingWebhookRequestData::class);
        $storing->handle($request);

        // verify/assert
        Event::assertNotDispatched(HookStored::class);
    }

    /**
     * @test
     */
    public function weSeeTheDifferenceBetweenAnSystemHookAndNormalHook(): void
    {
        // setup / mock
        Event::fake();
        $data = json_encode(['testfield' => 'testdata']);
        $request = new WebHookRequest();
        $request->content = $data;


        $systemData = json_encode(['testfield' => 'systemdata']);
        $systemRequest = new WebHookRequest();
        $systemRequest->content = $systemData;
        $systemRequest->headers['X-Gitlab-Event'] = 'System Hook';

        // run
        $storing = $this->app->make(StoreInComingWebhookRequestData::class);
        $storing->handle($request);
        $storing->handle($systemRequest);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data, 'system_hook' => false]);
        Event::assertDispatched(function (HookStored $hookStored) {
            return $hookStored->model->isSystemHook() === false;
        });
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $systemData, 'system_hook' => true]);
        Event::assertDispatched(function (HookStored $hookStored) {
            return $hookStored->model->isSystemHook() === true;
        });
    }

    /**
     * @test
     */
    public function weStoreTheObjectKind(): void
    {
        // setup / mock
        Event::fake();
        $objectKind = 'object_kind_' . mt_rand();
        $data = json_encode(['testfield' => 'testdata', 'object_kind' => $objectKind]);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = $this->app->make(StoreInComingWebhookRequestData::class);
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', ['body' => $data, 'object_kind' => $objectKind]);
        Event::assertDispatched(HookStored::class);
    }

    /**
     * @test
     */
    public function weStoreTheEventData(): void
    {
        // setup / mock
        Event::fake();
        $eventType = 'event_type_' . mt_rand();
        $eventName = 'event_name_' . mt_rand();
        $data = json_encode(['testfield' => 'testdata', 'event_type' => $eventType, 'event_name' => $eventName]);
        $request = new WebHookRequest();
        $request->content = $data;

        // run
        $storing = $this->app->make(StoreInComingWebhookRequestData::class);
        $storing->handle($request);

        // verify/assert
        $this->assertDatabaseHas('git_lab_hooks', [
            'body' => $data,
            'event_type' => $eventType,
            'event_name' => $eventName,
        ]);

        Event::assertDispatched(HookStored::class);
    }
}

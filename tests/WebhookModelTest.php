<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;
use TJVB\GitLabWebhooks\Models\GitLabHook;

class WebhookModelTest extends TestCase
{
    use DatabaseMigrations;
                                                                                                                                                                                                                                                                                                                       use WithFaker;

/**
     * @test
     */


    public function weImplementTheContract(): void
    {
        // setup / mock

        // run
        $gitlabHook = new GitLabHook();
    // verify/assert
        $this->assertInstanceOf(GitLabHookModel::class, $gitlabHook);
    }
    /**
     * @test
     */
    public function weCanStoreTheModel(): void
    {
        // setup / mock
        $gitlabHook = new GitLabHook();
        $body = ['test' => 'result'];
        $eventName = $this->faker->word();
        $eventType = $this->faker->word();
        $objectKind = $this->faker->word();
        $systemHook = $this->faker->boolean();
// run
        $savedHook = $gitlabHook->store($body, $eventName, $eventType, $objectKind, $systemHook);
// verify/assert
        $this->assertEquals($body, $savedHook->getBody());
        $this->assertEquals($eventName, $savedHook->getEventName());
        $this->assertEquals($eventType, $savedHook->getEventType());
        $this->assertEquals($objectKind, $savedHook->getObjectKind());
        $this->assertEquals($systemHook, $savedHook->isSystemHook());
        $this->assertDatabaseHas('git_lab_hooks', [
            'body' => json_encode($body),
            'event_name' => $eventName,
            'event_type' => $eventType,
            'object_kind' => $objectKind,
            'system_hook' => $systemHook,
        ]);
    }
}

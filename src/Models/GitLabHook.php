<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;

class GitLabHook extends Model implements GitLabHookModel
{
    use SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'body' => 'array',
        'system_hook' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'object_kind',
        'event_type',
        'event_name',
        'system_hook',
        'body',
    ];

    public function isSystemHook(): bool
    {
        return (bool) $this->getAttribute('system_hook');
    }

    public function getBody(): array
    {
        return $this->getAttribute('body');
    }

    public function getEventType(): string
    {
        return (string) $this->getAttribute('event_type');
    }

    public function getEventName(): string
    {
        return (string) $this->getAttribute('event_name');
    }

    public function getObjectKind(): string
    {
        return (string) $this->getAttribute('object_kind');
    }

    public function store(
        array $body,
        string $eventName,
        string $eventType,
        string $objectKind,
        bool $systemHook
    ): GitLabHookModel {
        $hook = new self();
        $hook->fill(
            [
                'body' => $body,
                'event_name' => $eventName,
                'event_type' => $eventType,
                'object_kind' => $objectKind,
                'system_hook' => $systemHook,
            ]
        );
        $hook->save();
        return $hook;
    }

    public function remove(): void
    {
        $this->delete();
    }
}

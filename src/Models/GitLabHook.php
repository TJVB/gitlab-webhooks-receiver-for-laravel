<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;

/**
 * @property bool $system_hook
 * @property array<mixed> $body
 * @property string $event_type
 * @property string $object_kind
 * @property string $event_name
 * @property Carbon $created_at
 */
class GitLabHook extends Model implements GitLabHookModel
{
    use SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'body' => 'array',
        'system_hook' => 'boolean',
    ];

    protected $fillable = [
        'object_kind',
        'event_type',
        'event_name',
        'system_hook',
        'body',
    ];

    public function isSystemHook(): bool
    {
        return $this->system_hook;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getEventType(): string
    {
        return $this->event_type;
    }

    public function getEventName(): string
    {
        return $this->event_name;
    }

    public function getObjectKind(): string
    {
        return $this->object_kind;
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

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->created_at->toImmutable();
    }
}

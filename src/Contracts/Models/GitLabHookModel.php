<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Models;

use Carbon\CarbonImmutable;

interface GitLabHookModel
{
    public function isSystemHook(): bool;

    /**
     * @return array<mixed>
     */
    public function getBody(): array;

    public function getEventType(): string;

    public function getEventName(): string;

    public function getObjectKind(): string;

    public function getCreatedAt(): CarbonImmutable;

    /**
     * @param array<mixed> $body
     */
    public function store(
        array $body,
        string $eventName,
        string $eventType,
        string $objectKind,
        bool $systemHook
    ): GitLabHookModel;

    public function remove(): void;
}

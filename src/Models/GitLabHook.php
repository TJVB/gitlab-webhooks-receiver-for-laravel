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
}

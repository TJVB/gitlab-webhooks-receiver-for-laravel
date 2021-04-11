<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TJVB\GitLabWebhooks\Contracts\Requests\GiLabWebhookRequest;

class GitLabWebhookRequest extends FormRequest implements GiLabWebhookRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}

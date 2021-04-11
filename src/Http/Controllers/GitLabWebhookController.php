<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TJVB\GitLabWebhooks\Contracts\Requests\GiLabWebhookRequest;

class GitLabWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param GiLabWebhookRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GiLabWebhookRequest $request): \Illuminate\Http\Response
    {
        return new Response('todo');
    }
}

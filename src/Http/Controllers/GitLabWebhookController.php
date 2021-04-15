<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Requests\GiLabWebhookRequest;
use TJVB\GitLabWebhooks\Exceptions\Exception;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;

class GitLabWebhookController extends Controller
{
    public function __invoke(InComingWebhookRequestStoring $requestStoring, GiLabWebhookRequest $request): Response
    {
        try {
            $requestStoring->handle($request);
            return new Response(null, Response::HTTP_CREATED);
        } catch (InvalidInputException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;

class GitLabWebhookController extends Controller
{
    public function __invoke(InComingWebhookRequestStoring $requestStoring, GitLabWebhookRequest $request): JsonResponse
    {
        try {
            $requestStoring->handle($request);
        } catch (InvalidInputException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Throwable $throwable) {
            return new JsonResponse('Failed to store webhook data', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}

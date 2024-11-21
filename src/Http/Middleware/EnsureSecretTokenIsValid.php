<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\JsonResponse;

class EnsureSecretTokenIsValid
{
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function handle(mixed $request, Closure $next): mixed
    {
        if (!$this->tokenIsValid($request)) {
            return new JsonResponse(['message' => 'invalid token'], JsonResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    private function tokenIsValid(mixed $request): bool
    {
        if (!is_object($request) || !method_exists($request, 'header')) {
            // it is possible that another middleware changed the request, we don't want to crash but give a 403
            return false;
        }
        $token = $request->header('X-Gitlab-Token');
        if (!is_string($token)) {
            return false;
        }
        $secrets = $this->config->get('gitlab-webhooks-receiver.valid_secrets', []);
        if (!is_array($secrets)) {
            return false;
        }
        return in_array($token, $secrets, true);
    }
}

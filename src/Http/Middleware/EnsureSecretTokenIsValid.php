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

    public function handle($request, Closure $next)
    {
        if (!$this->tokenIsValid($request)) {
            return new JsonResponse(['message' => 'invalid token'], JsonResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    private function tokenIsValid($request): bool
    {
        if (!method_exists($request, 'header')) {
            // it is possible that another middleware changed the request, we don't want to crash but give a 403
            return false;
        }
        $token = $request->header('X-Gitlab-Token');
        if (empty($token)) {
            return false;
        }
        $secrets = $this->config->get('gitlab-webhooks-receiver.valid_secrets', []);
        return in_array($token, $secrets, true);
    }
}

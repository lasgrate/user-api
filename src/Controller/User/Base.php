<?php

namespace App\Controller\User;

use App\Controller\Base as BaseController;
use App\Services\User\Create as CreateUserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Base extends BaseController
{
    public function create(Request $request, CreateUserService $createUserService)
    {
        $entry = $request->request->all();

        $result = $this->run(function () use ($createUserService, $entry) {
            return $createUserService->run($entry);
        });

        return new JsonResponse($result);
    }
}

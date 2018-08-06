<?php

namespace App\Controller\User;

use App\Controller\Base as BaseController;
use App\Services\User\Authorize as CreateUserAuthorizeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Session extends BaseController
{
    public function create(
        Request $request,
        SessionInterface $session,
        CreateUserAuthorizeService $createUserAuthorizeService
    ) {
        $entry = $request->request->all();

        $result = $this->run(function () use ($createUserAuthorizeService, $entry) {
            return $createUserAuthorizeService->run($entry);
        });

        if ($result['status']) {
            $session->set('id_user', $result['id_user']);
        }

        return new JsonResponse(['status' => $result['status']]);
    }
}

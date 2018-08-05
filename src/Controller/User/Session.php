<?php

namespace App\Controller\User;

use App\Controller\Base as BaseController;
use App\Services\User\Authorize as CreateUserAuthorizeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        return new Response(json_encode($result));
    }
}

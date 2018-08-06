<?php

namespace App\Controller\User;

use App\Controller\Base as BaseController;
use App\Services\User\Tracking\Create as CreateUserTrackingService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Tracking extends BaseController
{
    public function create(
        Request $request,
        SessionInterface $session,
        CreateUserTrackingService $createUserTrackingService
    ) {
        $entry = $request->request->all();
        $entry['id_user'] = $session->get('id_user') ?: $request->cookies->get('id_user', '');

        $result = $this->run(function () use ($createUserTrackingService, $entry) {
            return $createUserTrackingService->run($entry);
        });

        $response = new JsonResponse(['status' => $result['status']]);

        if ($result['status'] && !$result['is_authorize']) {
            $response->headers->setCookie(new Cookie('id_user', $result['id_user']));
        }

        return $response;
    }
}

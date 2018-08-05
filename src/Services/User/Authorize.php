<?php

namespace App\Services\User;

use App\Exceptions\WrongCredentialsException;
use App\Services\User\Base as BaseUserService;
use App\Services\Validator;

class Authorize extends BaseUserService
{
    final protected function validate($params): array
    {
        $rules = [
            'nickname' => ['required', 'string', 'not_empty', ['max_length' => 64]],
            'password' => ['required', 'string', 'not_empty', ['max_length' => 64]],
        ];

        return Validator::validate($params, $rules);
    }

    final protected function execute($validated): array
    {
        $user = $this->requireUserByNickname($validated['nickname']);

        if (!$user || !$user->checkPassword($validated['password'])) {
            throw new WrongCredentialsException();
        }

        return [
            'status' => 1,
            'id_user' => $user->getId(),
        ];
    }
}

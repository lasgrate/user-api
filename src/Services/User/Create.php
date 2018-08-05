<?php

namespace App\Services\User;

use App\Entity\User;
use App\Exceptions\ServiceException;
use App\Services\User\Base as BaseUserService;
use App\Services\Validator;

class Create extends BaseUserService
{
    final protected function validate($params): array
    {
        $rules = [
            'firstname' => ['required', 'string', 'not_empty', ['max_length' => 64]],
            'lastname' => ['required', 'string', 'not_empty', ['max_length' => 64]],
            'nickname' => ['required', 'string', 'not_empty', ['max_length' => 64]],
            'age' => ['required', 'positive_integer', ['max_length' => 256]],
            'password' => ['required', 'string', 'not_empty', ['max_length' => 64]],
        ];

        return Validator::validate($params, $rules);
    }

    final protected function execute($validated): array
    {
        if ($this->userModel->findByNickname($validated['nickname'])) {
            throw new ServiceException("User with nickname {$validated['nickname']} already exist.");
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_DEFAULT);
        $this->userModel->insert(new User($validated));

        return ['status' => 1];
    }
}

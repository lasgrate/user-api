<?php

namespace App\Services\User;

use App\Exceptions\ServiceException;
use App\Services\Base as BaseUserService;
use Psr\Log\LoggerInterface;
use App\Models\User as UserModel;

abstract class Base extends BaseUserService
{
    protected $userModel;

    public function __construct(LoggerInterface $logger, UserModel $userModel)
    {
        parent::__construct($logger);

        $this->userModel = $userModel;
    }

    protected function requireUserByNickname($nickname)
    {
        $user = $this->userModel->findByNickname($nickname);

        if (!$user) {
            throw new ServiceException("User with nickname {$nickname} already exist.");
        }

        return $user;
    }
}

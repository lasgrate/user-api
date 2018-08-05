<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Base extends AbstractController
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function run(callable $cb): array
    {
        try {
            $result = call_user_func($cb);
        } catch (\Exception $e) {
            $this->logger->error("Internal server error: {$e->getMessage()}.");
            $result = ['status' => 0];
        }

        return $result;
    }
}

<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use Psr\Log\LoggerInterface;

abstract class Base
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Trigger service. First validate entry data, then execute service.
     *
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    final public function run(array $params = [])
    {
        try {
            $validated = $this->validate($params);
            $result = $this->execute($validated);
        } catch (ServiceException $e) {
            $result = $e->getError();
            $this->logger->error(
                sprintf(
                    'Service exception with message %s: %s.',
                    $e->getMessage(),
                    json_encode($e->getError())
                )
            );
        }

        return $result;
    }

    abstract protected function validate($params): array;

    abstract protected function execute($validated): array;
}

<?php

namespace App\Models;

use App\Exceptions\ServiceException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class Base
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $storageDirPath;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->filesystem = new Filesystem();
        $this->storageDirPath = __DIR__ . '/../../var/storage/';

        if (!$this->filesystem->exists($this->storageDirPath)) {
            $this->filesystem->mkdir($this->storageDirPath);
        }
    }

    protected function insertIntoFile($file, $data)
    {
        try {
            $this->filesystem->dumpFile($file, $data);
        } catch (IOException $e) {
            $this->logger->error(
                sprintf(
                    "Can't append data to file %s: %s.",
                    $file,
                    $e->getMessage()
                )
            );

            throw new ServiceException("Can't save file to storage.");
        }
    }
}

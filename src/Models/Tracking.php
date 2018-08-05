<?php

namespace App\Models;

use Psr\Log\LoggerInterface;
use App\Entity\Tracking as TrackingEntity;

class Tracking extends Base
{
    /**
     * unique column
     */
    const COL_ID = 'id';

    /**
     * unique column. 'foreign key' on \App\Models\User
     */
    const COL_USER_ID = 'id_user';

    const COL_SOURCE_LABEL = 'source_label';

    const COL_DATE_CREATED = 'date_created';

    const FILENAME = 'tracking.json';

    /**
     * @var string
     */
    private $storageFile;

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);

        $this->storageFile = $this->storageDirPath . self::FILENAME;

        if (!$this->filesystem->exists($this->storageFile)) {
            $this->filesystem->touch($this->storageFile);
        }
    }

    public function insert(TrackingEntity $tracking): void
    {
        $trackingArr = json_decode(file_get_contents($this->storageFile), true) ?: [];
        array_push($trackingArr, self::exportToArray($tracking));
        $this->insertIntoFile($this->storageFile, json_encode($trackingArr, JSON_PRETTY_PRINT));
    }

    public static function exportToArray(TrackingEntity $tracking): array
    {
        return [
            self::COL_ID => $tracking->getId(),
            self::COL_USER_ID => $tracking->getUserId(),
            self::COL_SOURCE_LABEL => $tracking->getSourceLabel(),
            self::COL_DATE_CREATED => $tracking->getCreatedDate(),
        ];
    }
}

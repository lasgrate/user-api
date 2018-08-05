<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;

class Tracking
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $sourceLabel;

    /**
     * @var string
     */
    private $createdDate;

    /**
     * Tracking constructor.
     *
     * Expects an array of next elements
     *  - @string 'id_user' - a so-called foreign key on \App\Models\User
     *  - @string 'source_label' - identify kind of user action
     *
     * @param array $tracingData
     * @throws \Exception
     */
    public function __construct(array $tracingData = [])
    {
        $this->id = Uuid::uuid4();
        $this->userId = $tracingData['id_user'] ?? '';
        $this->sourceLabel = $tracingData['source_label'] ?? '';
        $this->createdDate = date('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->sourceLabel;
    }

    /**
     * @param string $sourceLabel
     */
    public function setSourceLabel(string $sourceLabel): void
    {
        $this->sourceLabel = $sourceLabel;
    }

    /**
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    /**
     * @param string $createdDate
     */
    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }
}

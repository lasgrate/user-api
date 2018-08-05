<?php

namespace App\Models;

use App\Entity\User as UserEntity;
use Psr\Log\LoggerInterface;

class User extends Base
{
    /**
     * Unique column
     */
    const COL_ID = 'id';

    /**
     * Unique column
     */
    const COL_NICKNAME = 'nickname';

    const COL_LASTNAME = 'lastname';

    const COL_FIRSTNAME= 'firstname';

    const COL_AGE = 'age';

    const COL_PASSWORD = 'password';

    const FILENAME = 'user.json';

    /**
     * @var string
     */
    private $storageFile;

    /**
     * @var array|User[]
     */
    private $users = [];

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);

        $this->storageFile = $this->storageDirPath . self::FILENAME;

        if (!$this->filesystem->exists($this->storageFile)) {
            $this->filesystem->touch($this->storageFile);
        }
    }

    public function insert(UserEntity $user): void
    {
        $usersArr = json_decode(file_get_contents($this->storageFile), true) ?: [];
        array_push($usersArr, self::exportToArray($user));
        $this->insertIntoFile($this->storageFile, json_encode($usersArr, JSON_PRETTY_PRINT));
    }

    public function getAll(bool $force = false): array
    {
        if ($this->users && !$force) {
            return $this->users;
        }

        $users = json_decode(file_get_contents($this->storageFile), true) ?: [];

        foreach ($users as $user) {
            $this->users[] = new UserEntity($user);
        }

        return $this->users;
    }

    /**
     * @param string $nickname
     * @return UserEntity|null
     * @throws \Exception
     */
    public function findByNickname(string $nickname)
    {
        return $this->findByField('nickname', $nickname);
    }

    /**
     * @param string $id
     * @return UserEntity|null
     * @throws \Exception
     */
    public function findById(string $id)
    {
        return $this->findByField('id', $id);
    }

    /**
     * @param $fieldName
     * @param $fieldValue
     * @return UserEntity|null
     * @throws \Exception
     */
    public function findByField($fieldName, $fieldValue)
    {
        $getter = 'get' . ucfirst($fieldName);

        try {
            $users = $this->getAll();

            foreach ($users as $user) {
                if ($user->$getter() === $fieldValue) {
                    return $user;
                }
            }

            return null;
        } catch (\Exception $e) {
            $this->logger->error("Undefined method ${$getter} in \App\Entity\User.");

            throw $e;
        }
    }

    public static function exportToArray(UserEntity $user): array
    {
        return [
            self::COL_ID => $user->getId(),
            self::COL_NICKNAME => $user->getNickname(),
            self::COL_LASTNAME => $user->getLastname(),
            self::COL_FIRSTNAME => $user->getFirstname(),
            self::COL_AGE => $user->getAge(),
            self::COL_PASSWORD => $user->getPassword(),
        ];
    }
}

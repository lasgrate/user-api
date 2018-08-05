<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;

class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $nickname = '';

    /**
     * @var string
     */
    private $lastname = '';

    /**
     * @var string
     */
    private $firstname = '';

    /**
     * @var int
     */
    private $age = 0;

    /**
     * @var string
     */
    private $password = '';

    /**
     * User constructor.
     *
     * Expects an array of next elements
     *  - @string 'nickname' - user nickname
     *  - @string 'lastname' - user lastname
     *  - @string 'firstname' - user firstname
     *  - @int 'age' - user age
     *  - @string 'password' - user password
     *
     *  Authorize unique user id
     *
     * @param array $userData
     * @throws \Exception
     */
    public function __construct(array $userData = [])
    {
        $this->id = Uuid::uuid4();
        $this->nickname = $userData['nickname'] ?? '';
        $this->lastname = $userData['lastname'] ?? '';
        $this->firstname = $userData['firstname'] ?? '';
        $this->age = $userData['age'] ?? 0;
        $this->password = $userData['password'];
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
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Compare entry password with real user password
     *
     * @param $password
     * @return bool
     */
    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }
}

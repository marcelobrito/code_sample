<?php

namespace App\Entities;

use \JsonSerializable;

/**
 * Class User
 * @package App\Entities
 */
class User implements JsonSerializable
{
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $password;
    /**
     * @var string
     */
    private string $name;

    /**
     * User constructor.
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function __construct(string $email, string $name, string $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return ['email' => $this->email, 'name' => $this->name];
    }
}

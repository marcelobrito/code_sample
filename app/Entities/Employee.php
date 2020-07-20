<?php

namespace App\Entities;

use \JsonSerializable;

/**
 * Class Employee
 * @package App\Entities
 */
class Employee implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $email;

    public function __construct(
        int $id,
        string $name,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}

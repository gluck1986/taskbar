<?php

namespace App\Entity;

class Task
{
    public ?int $id;

    public string $name;

    public string $email;

    public string $description;

    public bool $isReady = false;

    public bool $isEdited = false;

    /**
     * Task constructor.
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $description
     * @param bool $isReady
     * @param bool $isEdited
     */
    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $description,
        bool $isReady = false,
        bool $isEdited = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        $this->isReady = $isReady;
        $this->isEdited = $isEdited;
    }
}

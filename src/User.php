<?php

namespace harlam\OpenVPN;

class User
{
    /** @var integer */
    public $id;
    /** @var string */
    public $username;
    /** @var string */
    public $password;
    /** @var boolean */
    public $is_active;
    /** @var string */
    public $created_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
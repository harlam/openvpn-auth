<?php

namespace harlam\OpenVPN;

use DateTime;
use DateTimeZone;

class User
{
    /** @var string */
    public $username;
    /** @var string */
    public $password;
    /** @var boolean */
    public $is_active;
    /** @var string */
    public $created_at;

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
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        $result = DateTime::createFromFormat('Y-m-d H:i:s.u', $this->created_at, new DateTimeZone('UTC'));

        if ($result === false) {
            return null;
        }

        return $result;
    }
}
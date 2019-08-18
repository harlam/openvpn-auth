<?php

namespace harlam\OpenVPN;

/**
 * Authentication request
 * @package harlam\OpenVPN
 */
class AuthRequest
{
    protected $username;
    protected $password;
    protected $remoteIp;

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
     * @return string|null
     */
    public function getRemoteIp(): ?string
    {
        return $this->remoteIp;
    }

    /**
     * @param string $username
     * @return AuthRequest
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @return AuthRequest
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string|null $remoteIp
     * @return AuthRequest
     */
    public function setRemoteIp(?string $remoteIp): self
    {
        $this->remoteIp = $remoteIp;
        return $this;
    }
}
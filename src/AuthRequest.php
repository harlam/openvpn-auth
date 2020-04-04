<?php

namespace harlam\OpenVPN\Auth;

/**
 * OpenVPN authentication request
 * @package harlam\OpenVPN
 */
class AuthRequest
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var string */
    protected $remoteIp;

    /**
     * AuthRequest constructor.
     * @param string $username
     * @param string $password
     * @param string $remoteIp
     */
    public function __construct($username, $password, $remoteIp)
    {
        $this->username = $username;
        $this->password = $password;
        $this->remoteIp = $remoteIp;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    public function __toString()
    {
        return "Username: {$this->username}, Remote IP: {$this->remoteIp}";
    }
}
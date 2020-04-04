<?php

namespace harlam\OpenVPN\Auth;

use harlam\OpenVPN\Auth\Exceptions\BaseException;

/**
 * Authentication request builder
 * @package harlam\OpenVPN
 */
class AuthRequestBuilder
{
    /**
     * @return AuthRequest
     * @throws BaseException
     */
    public static function buildFromEnvironment()
    {
        if (($username = getenv('username')) === false) {
            throw new BaseException('Environment variable \'username\' is not present');
        }

        if (($password = getenv('password')) === false) {
            throw new BaseException('Environment variable \'password\' is not present');
        }

        if (($remoteIp = getenv('untrusted_ip')) === false) {
            throw new BaseException('Environment variable \'untrusted_ip\' is not present');
        }

        return new AuthRequest($username, $password, $remoteIp);
    }
}
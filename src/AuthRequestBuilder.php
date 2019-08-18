<?php

namespace harlam\OpenVPN;

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
    public static function buildFromEnvironment(): AuthRequest
    {
        $request = new AuthRequest();

        if (($username = getenv('username')) === false) {
            throw new BaseException('Environment variable \'username\' is not present');
        }

        if (($password = getenv('password')) === false) {
            throw new BaseException('Environment variable \'password\' is not present');
        }

        if (($remoteIp = getenv('untrusted_ip')) === false) {
            throw new BaseException('Environment variable \'untrusted_ip\' is not present');
        }

        $request->setUsername($username)
            ->setPassword($password)
            ->setRemoteIp($remoteIp);

        return $request;
    }
}
<?php

namespace harlam\OpenVPN\Auth\Interfaces;

use harlam\OpenVPN\Auth\AuthRequest;
use harlam\OpenVPN\Auth\Exceptions\AuthenticationException;

interface AuthServiceInterface
{
    /**
     * @param AuthRequest $authRequest
     * @throws AuthenticationException
     */
    public function authenticate(AuthRequest $authRequest);
}
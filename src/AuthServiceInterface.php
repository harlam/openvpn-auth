<?php

namespace harlam\OpenVPN;

interface AuthServiceInterface
{
    /**
     * @param AuthRequest $authRequest
     * @throws AuthenticationException
     */
    public function authenticate(AuthRequest $authRequest): void;
}
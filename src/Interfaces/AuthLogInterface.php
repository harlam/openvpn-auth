<?php

namespace harlam\OpenVPN\Auth\Interfaces;

use harlam\OpenVPN\Auth\AuthRequest;

interface AuthLogInterface
{
    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function success(AuthRequest $request, $details = null);

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, $details = null);
}
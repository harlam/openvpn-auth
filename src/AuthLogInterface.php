<?php

namespace harlam\OpenVPN;

interface AuthLogInterface
{
    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function success(AuthRequest $request, string $details = null): void;

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, string $details = null): void;
}
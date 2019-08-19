<?php

namespace harlam\OpenVPN;

class AuthLogFile implements AuthLogInterface
{
    protected $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function success(AuthRequest $request, string $details = null): void
    {
        $this->log($request, true, $details);
    }

    protected function log(AuthRequest $request, bool $success, string $details = null): void
    {
        $successLabel = $success ? 'Login success' : 'Login failed';
        $passwordLabel = $success === true ? '' : ' with password: ' . $request->getPassword();
        $date = date('c');

        $log = "{$date} {$request->getRemoteIp()} {$successLabel}: '{$request->getUsername()}'{$passwordLabel}. Details: {$details}" . PHP_EOL;

        file_put_contents(date('Y_m_') . $this->filename . '.log', $log, FILE_APPEND);
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, string $details = null): void
    {
        $this->log($request, false, $details);
    }
}
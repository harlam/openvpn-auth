<?php

namespace harlam\OpenVPN\Auth;

use harlam\OpenVPN\Auth\Exceptions\BaseException;
use harlam\OpenVPN\Auth\Interfaces\AuthLogInterface;

class AuthLogFile implements AuthLogInterface
{
    protected $directory;
    protected $filename;

    /**
     * AuthLogFile constructor.
     * @param string $directory
     * @param string $filename
     * @throws BaseException
     */
    public function __construct($directory, $filename)
    {
        $this->directory = realpath($this->directory);

        if ($this->directory === false) {
            throw new BaseException("Failed to initialize in directory '{$directory}'");
        }

        $this->filename = $filename;
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function success(AuthRequest $request, $details = null)
    {
        $this->log($request, true, $details);
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, $details = null)
    {
        $this->log($request, false, $details);
    }

    /**
     * @param AuthRequest $request
     * @param string $success
     * @param string|null $details
     */
    protected function log(AuthRequest $request, $success, $details = null)
    {
        $successLabel = $success ? 'Login success' : 'Login failed';

        $date = date('c');

        $log = "{$date} {$request->getRemoteIp()} {$successLabel}: '{$request->getUsername()}'. Details: {$details}" . PHP_EOL;

        file_put_contents($this->directory . DIRECTORY_SEPARATOR . date('Y_m_') . $this->filename . '.log', $log, FILE_APPEND);
    }
}
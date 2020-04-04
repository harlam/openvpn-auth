#!/usr/bin/env php
<?php

use Dotenv\Dotenv;
use harlam\OpenVPN\Auth\AuthRequest;
use harlam\OpenVPN\Auth\Exceptions\AuthenticationException;
use harlam\OpenVPN\Auth\Interfaces\AuthLogInterface;
use harlam\OpenVPN\Auth\Interfaces\AuthServiceInterface;
use Pimple\Psr11\Container;

require_once 'vendor/autoload.php';

$errorLogFile = 'error.log';

try {
    /** @var Container $container */
    $container = require_once 'container.php';

    /** @var Dotenv $env */
    $env = $container->get(Dotenv::class);
    $env->load();

    /** @var string $errorLogFile Override errors file path */
    $errorLogFile = ($l = getenv('ERROR_LOG_FILE')) === false ? $errorLogFile : $l;

    /** @var AuthServiceInterface $authService */
    $authService = $container->get(AuthServiceInterface::class);

    /** @var AuthLogInterface $authLog */
    $authLog = $container->get(AuthLogInterface::class);

    /** @var AuthRequest $authRequest */
    $authRequest = $container->get(AuthRequest::class);

    $authService->authenticate($authRequest);

    $authLog->success($authRequest);
    exit(0);
} catch (AuthenticationException $authException) {
    $authLog->fail($authRequest, $authException->getMessage());
} catch (Exception $exception) {
    $message = date('c') . " Error {$exception->getMessage()}, File: {$exception->getFile()}, Line: {$exception->getLine()}" . PHP_EOL;
    error_log($message, 3, $errorLogFile);
}
exit(1);
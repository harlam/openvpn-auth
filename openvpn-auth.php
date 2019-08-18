#!/usr/bin/env php

<?php

use harlam\OpenVPN\AuthenticationException;
use harlam\OpenVPN\AuthLogInterface;
use harlam\OpenVPN\AuthRequest;
use harlam\OpenVPN\AuthServiceInterface;
use Pimple\Container;

require_once 'vendor/autoload.php';

putenv("username=test");
putenv("password=test");
putenv("untrusted_ip=192.168.0.1");

try {
    /** @var Container $container */
    $container = require_once 'container.php';

    /** @var AuthServiceInterface $authService */
    $authService = $container['service.auth'];

    /** @var AuthLogInterface $authLog */
    $authLog = $container['service.auth.log'];

    /** @var AuthRequest $authRequest */
    $authRequest = $container['builder.authRequest'];

    $authService->authenticate($authRequest);

    $authLog->success($authRequest);
    exit(0);
} catch (AuthenticationException $authException) {
    $authLog->fail($authRequest, $authException->getMessage());
} catch (Exception $exception) {
    /** log exceptions */
    print_r($exception->getMessage() . PHP_EOL);
}
exit(1);

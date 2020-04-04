<?php

use Dotenv\Dotenv;
use harlam\OpenVPN\Auth\AuthLogDatabase;
use harlam\OpenVPN\Auth\AuthRequest;
use harlam\OpenVPN\Auth\AuthRequestBuilder;
use harlam\OpenVPN\Auth\AuthService;
use harlam\OpenVPN\Auth\Interfaces\AuthLogInterface;
use harlam\OpenVPN\Auth\Interfaces\AuthServiceInterface;
use harlam\OpenVPN\Users\Interfaces\StorageInterface;
use harlam\OpenVPN\Users\UserStorageDatabase;
use Pimple\Container;
use Pimple\Psr11\Container as PsrContainer;

$container = new Container();

/**
 * @return Dotenv
 */
$container[Dotenv::class] = function () {
    return Dotenv::createImmutable(__DIR__);
};

/**
 * OpenVPN Auth-request builder
 * @return AuthRequest
 */
$container[AuthRequest::class] = $container->factory(function () {
    return AuthRequestBuilder::buildFromEnvironment();
});

/**
 * PDO
 * @return AuthRequest
 */
$container[PDO::class] = $container->factory(function () {
    return new PDO(getenv('PDO_DSN'), getenv('PDO_USERNAME'), getenv('PDO_PASSWORD'));
});

/**
 * Users storage
 * @param Container $container
 * @return StorageInterface
 */
$container[StorageInterface::class] = function (Container $container) {
    /** @var PDO $pdo */
    $pdo = $container[PDO::class];

    return new UserStorageDatabase($pdo);
};

/**
 * @param Container $container
 * @return AuthLogInterface
 */
$container[AuthLogInterface::class] = function (Container $container) {
    /** @var PDO $pdo */
    $pdo = $container[PDO::class];

    return new AuthLogDatabase($pdo);
};

/**
 * @param Container $container
 * @return AuthServiceInterface
 */
$container[AuthServiceInterface::class] = function (Container $container) {
    /** @var StorageInterface $storage */
    $storage = $container[StorageInterface::class];

    return new AuthService($storage);
};

return new PsrContainer($container);
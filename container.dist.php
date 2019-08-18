<?php

use harlam\OpenVPN\AuthLog;
use harlam\OpenVPN\AuthLogInterface;
use harlam\OpenVPN\AuthRequestBuilder;
use harlam\OpenVPN\AuthService;
use harlam\OpenVPN\AuthServiceInterface;
use harlam\OpenVPN\BaseException;
use harlam\OpenVPN\UserStorage;
use harlam\OpenVPN\UserStorageInterface;
use harlam\Password\Interfaces\PasswordInterface;
use harlam\Password\Password;
use Pimple\Container;

$container = new Container();

/**
 * PDO-подключение к базе данных
 * @return PDO
 */
$container['pdo'] = function () {
    $dsn = 'pgsql:host=localhost;port=5432;dbname=openvpn';
    $username = 'postgres';
    $password = 'secret';

    return new PDO($dsn, $username, $password);
};

/**
 * Builder запроса на авторизацию
 * @return \harlam\OpenVPN\AuthRequest
 */
$container['builder.authRequest'] = $container->factory(function () {
    return AuthRequestBuilder::buildFromEnvironment();
});

/**
 * Хранилище пользователей
 * @param Container $container
 * @return UserStorageInterface
 */
$container['storage.user'] = function (Container $container) {
    /** @var PDO $pdo */
    $pdo = $container['pdo'];

    return new UserStorage($pdo);
};

/**
 * Сервис для работы с паролями
 * @return PasswordInterface
 */
$container['service.password'] = function () {
    $passwordService = (new Password())
        ->setPasswordLength(16, 64)
        ->setPasswordComplexity(function (string $password) {
            if (preg_match('/[A-Z]/', $password) !== 1) {
                throw new BaseException('Пароль должен содержать хотя-бы одну заглавную букву');
            }
        })->setPasswordComplexity(function (string $password) {
            if (preg_match('/[0-9]/', $password) !== 1) {
                throw new BaseException('Пароль должен содержать хотя-бы одну цифру');
            }
        });

    return $passwordService;
};

/**
 * @param Container $container
 * @return AuthServiceInterface
 */
$container['service.auth'] = function (Container $container) {
    /** @var UserStorageInterface $storage */
    $storage = $container['storage.user'];
    /** @var PasswordInterface $passwordService */
    $passwordService = $container['service.password'];

    return new AuthService($storage, $passwordService);
};

/**
 * @param Container $container
 * @return AuthLogInterface
 */
$container['service.auth.log'] = function (Container $container) {
    /** @var PDO $pdo */
    $pdo = $container['pdo'];

    return new AuthLog($pdo);
};

return $container;
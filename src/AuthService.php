<?php

namespace harlam\OpenVPN\Auth;

use harlam\OpenVPN\Auth\Exceptions\AuthenticationException;
use harlam\OpenVPN\Auth\Interfaces\AuthServiceInterface;
use harlam\OpenVPN\Users\Exceptions\UserNotFoundException;
use harlam\OpenVPN\Users\Interfaces\StorageInterface;

/**
 * Class AuthService
 * @package harlam\OpenVPN\Auth
 */
class AuthService implements AuthServiceInterface
{
    protected $userStorage;

    /**
     * AuthService constructor.
     * @param StorageInterface $userStorage
     */
    public function __construct(StorageInterface $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    /**
     * @param AuthRequest $authRequest
     * @throws AuthenticationException
     */
    public function authenticate(AuthRequest $authRequest)
    {
        try {
            $user = $this->userStorage->findByUsername($authRequest->getUsername());
        } catch (UserNotFoundException $exception) {
            throw new AuthenticationException("User with name '{$authRequest->getUsername()}' not found");
        }

        if ($user->is_active !== true) {
            throw new AuthenticationException("User '{$user->getUsername()}' inactive");
        }

        if (password_verify($authRequest->getPassword(), $user->getPassword()) === false) {
            throw new AuthenticationException("Invalid password for user '{$user->getUsername()}'");
        }
    }
}
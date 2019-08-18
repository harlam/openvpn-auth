<?php

namespace harlam\OpenVPN;

use harlam\Password\Interfaces\PasswordInterface;

class AuthService implements AuthServiceInterface
{
    protected $userStorage;
    protected $passwordService;

    public function __construct(UserStorageInterface $userStorage, PasswordInterface $passwordService)
    {
        $this->userStorage = $userStorage;
        $this->passwordService = $passwordService;
    }

    /**
     * @param AuthRequest $authRequest
     * @throws AuthenticationException
     */
    public function authenticate(AuthRequest $authRequest): void
    {
        try {
            $user = $this->userStorage->findByUsername($authRequest->getUsername());
        } catch (UserNotFoundException $exception) {
            throw new AuthenticationException("User with name '{$authRequest->getUsername()}' not found");
        }

        if ($user->is_active !== true) {
            throw new AuthenticationException("User '{$user->getUsername()}' is not active");
        }

        $passwordIsValid = $this->passwordService
            ->setPassword($authRequest->getPassword())
            ->verify($user->getPassword());

        if ($passwordIsValid === false) {
            throw new AuthenticationException("Invalid password for user '{$user->getUsername()}'");
        }
    }
}
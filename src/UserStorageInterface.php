<?php

namespace harlam\OpenVPN;

interface UserStorageInterface
{
    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User;
}
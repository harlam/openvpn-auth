<?php

namespace harlam\OpenVPN;

use PDO;
use RuntimeException;

class UserStorage implements UserStorageInterface
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User
    {
        $query = $this->pdo->prepare('select * from users where username = :username');

        if ($query->bindValue('username', $username, PDO::PARAM_STR) === false) {
            throw new RuntimeException('Bind value failure');
        }

        if ($query->execute() === false) {
            throw new RuntimeException('Query exec failure');
        }

        $result = $query->fetchObject(User::class);

        if ($result === false) {
            throw new UserNotFoundException("User with name '{$username}' not found");
        }

        return $result;
    }

    public function create(User $user): void
    {

    }
}
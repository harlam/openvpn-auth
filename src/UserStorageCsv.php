<?php

namespace harlam\OpenVPN;

class UserStorageCsv implements UserStorageInterface
{
    protected $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(string $username): User
    {
        if (($handle = fopen($this->filename, "r")) === false) {
            throw new UserNotFoundException('Storage error');
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (isset($data[0]) && $data[0] === $username) {
                $user = new User();
                $user->username = isset($data[0]) ? $data[0] : null;
                $user->password = isset($data[1]) ? $data[1] : null;
                $user->is_active = isset($data[2]) && $data[2] === 'active' ? true : false;
                $user->created_at = isset($data[3]) ? $data[3] : null;
                return $user;
            }
        }

        fclose($handle);

        throw new UserNotFoundException("User with name '{$username}' not found");
    }

    public function create(User $user): void
    {

    }
}
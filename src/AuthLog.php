<?php

namespace harlam\OpenVPN;

use PDO;

class AuthLog implements AuthLogInterface
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function success(AuthRequest $request, string $details = null): void
    {
        $this->log($request, true, $details);
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, string $details = null): void
    {
        $this->log($request, false, $details);
    }

    protected function log(AuthRequest $request, bool $success, string $details = null): void
    {
        $sql = 'insert into auth_log(username, password, ip_addr, is_success, details) values'
            . '(:username, :password, :remote_ip, :success, :details);';

        $query = $this->pdo->prepare($sql);

        $password = $success === true ? '<hidden>' : $request->getPassword();

        $query->bindValue('username', $request->getUsername(), PDO::PARAM_STR);
        $query->bindValue('password', $password, PDO::PARAM_STR);
        $query->bindValue('remote_ip', $request->getRemoteIp(), PDO::PARAM_STR);
        $query->bindValue('success', $success, PDO::PARAM_BOOL);
        $query->bindValue('details', $details, PDO::PARAM_STR);

        $query->execute();
    }
}
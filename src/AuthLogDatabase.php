<?php

namespace harlam\OpenVPN\Auth;

use harlam\OpenVPN\Auth\Interfaces\AuthLogInterface;
use PDO;

class AuthLogDatabase implements AuthLogInterface
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
    public function success(AuthRequest $request, $details = null)
    {
        $this->log($request, true, $details);
    }

    /**
     * @param AuthRequest $request
     * @param string|null $details
     */
    public function fail(AuthRequest $request, $details = null)
    {
        $this->log($request, false, $details);
    }

    /**
     * @param AuthRequest $request
     * @param $success
     * @param null|string $details
     */
    protected function log(AuthRequest $request, $success, $details = null)
    {
        $sql = 'insert into auth_log(username, ip_addr, is_success, details) values'
            . '(:username, :remote_ip, :success, :details);';

        $query = $this->pdo->prepare($sql);

        $query->bindValue('username', $request->getUsername(), PDO::PARAM_STR);
        $query->bindValue('remote_ip', $request->getRemoteIp(), PDO::PARAM_STR);
        $query->bindValue('success', $success, PDO::PARAM_BOOL);
        $query->bindValue('details', $details, PDO::PARAM_STR);

        $query->execute();
    }
}
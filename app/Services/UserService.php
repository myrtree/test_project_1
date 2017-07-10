<?php

namespace Services;

use Simple\Storage;

class UserService
{
    private $pdo;

    public function __construct()
    {
        $settings = Storage::get('settings');
        $this->pdo = new \PDO($settings['pdoConnectionString'], $settings['mysqlUser'], $settings['mysqlPass']);
    }

    public function create(string $name, string $email, string $password, bool $isAdmin = false): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, is_admin) VALUES (:name, :email, :password_hash, :is_admin)'
        );

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $hash,
            ':is_admin' => $isAdmin
        ]);

        return $this->pdo->lastInsertId();
    }

    public function logIn(string $email, string $password)
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, password_hash FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute([
            'email' => $email
        ]);
        $user = $stmt->fetch();

        if (!user) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        $uid = uniqid();

        $stmt = $this->pdo->prepare('UPDATE users SET auth_uid = :auth_uid WHERE id = :user_id');
        $stmt->execute([
            'auth_uid' => $uid,
            'user_id' => $user['id']
        ]);

        setcookie('auth_uid', $uid, strtotime('+30 days'));

        return $user['id'];
    }

    public function getUser()
    {
        $authUid = filter_input(INPUT_COOKIE, 'auth_uid');
        if (!$authUid) {
            return false;
        }

        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, is_admin FROM users WHERE auth_uid = :auth_uid LIMIT 1'
        );
        $stmt->execute([
            'auth_uid' => $authUid
        ]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function logOut()
    {
        setcookie('auth_uid', '');
    }
}

<?php

namespace CFW\Access;

use Exception;
use CFW\Traits\Input;
use CFW\Settings\Cookie;
use CFW\Settings\Session;

class User
{
    use Input;

    public $username, $password;
    public $userData = [];

    public function logout()
    {
        Cookie::kill_all();
        Session::kill_all();
        header("Location: /login");
    }

    public function login()
    {
        if (!isset($_POST)) {
            throw new Exception(die("No POST SET"));
        }

        $this->username = self::validate($_POST['username']);
        $this->password = self::validate($_POST['password']);

        $sql = "SELECT * FROM `users` WHERE `username` = :username LIMIT 1";

        $conn = db_connect();
        $userData = db_prepared($conn, $sql, ['username' => $this->username]);

        $this->authenticate($userData);
    }

    private function authenticate($userData)
    {
        $_SERVER['error']['message'] = "";

        if (!isset($userData) || empty($userData) || !password_verify($this->password, $userData['password'])) {
            $_SESSION['error']['message'] = "Invalid username or password. Please try again.";
            $this->authenticationFailed($userData);
        } elseif (in_array($userData['status'], ['suspended', 'banned', 'restricted'])) {
            $state = strtoupper($userData['status']);

            $_SESSION['error']['message'] = "User is {$state}. Please contact the system administrator for any questions.";

            $this->authenticationFailed($userData);
        } else {
            $this->authenticated($userData);
        }
    }

    private function authenticated($userData)
    {
        $keys = [];

        unset($_SESSION['error']['message']);

        $params = [
            'last_login' => date('Y-m-d H:i:s', strtotime("now")),
            'failed_attempts' => 0,
            'status' => 'active',
            'reset_key' => null,
            'reset_expiration' => null
        ];

        foreach ($params as $key => $value) {
            array_push($keys, "`{$key}`=:{$key}");
        }

        $set = implode(', ', $keys);
        $params['username'] = $this->username;

        $sql = "UPDATE `users` SET {$set} WHERE `username` = :username LIMIT 1";
        $conn = db_connect();
        $userData = db_prepared($conn, $sql, $params);

        $_SESSION['user'] = [
            'user_id' => $userData['user_id'],
            'username' => $this->username,
            'theme' => $userData['theme']
        ];

        header("Location: /");
    }

    private function authenticationFailed($userData)
    {
        $params = [];
        $failed_attempts = $userData['failed_attempts'] + 1;
        $params['failed_attempts'] = $failed_attempts;

        if ($failed_attempts >= 3) {
            $params['status'] = 'restricted';
        } else {
            $params['status'] = $userData['status'];
        }

        $params['user_id'] = $userData['user_id'];

        $conn = db_connect();
        $userData = db_prepared($conn, "UPDATE `users` SET `failed_attempts` = :failed_attempts, `status` = :status WHERE `user_id` = :user_id LIMIT 1", $params);

        $this->logout();
    }
}

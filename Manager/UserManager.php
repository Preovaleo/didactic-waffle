<?php

namespace Minifier\Manager;

use Minifier\Repository\UserRepository;
use Minifier\Model\User;

class UserManager
{

    /**
     *
     * @var UserRepository
     */
    private $userR;

    public function __construct(UserRepository $userR)
    {
        $this->userR = $userR;
    }

    public function login($username, $password)
    {
        $user = $this->userR->fetchbyUsername($username);
        if ($user === false) {
            return false;
        }

        if (password_verify($password, $user->hash)) {
            $this->doLogin($user);
            return true;
        }

        return false;
    }

    private function doLogin(User $user)
    {
        $_SESSION['userID'] = $user->id;
    }

    private function doLogout()
    {
        session_destroy();
    }

    public function isLoggedin()
    {
        return array_key_exists('userID', $_SESSION);
    }

    public function logout()
    {
        $this->doLogout();
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     */
    public function createUser($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->hash = password_hash($password, PASSWORD_BCRYPT);
        return $this->userR->add($user);
    }
}

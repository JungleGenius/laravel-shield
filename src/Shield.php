<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/vinkla/laravel-shield
 */

//declare(strict_types=1);

namespace Vinkla\Shield;

class Shield
{
    protected $users;

    protected $currentUser;

    public function __construct($users = [])
    {
        $this->users = $users;
    }

    public function verify($username, $password, $user = null)
    {
        if ($username === null || $password === null) {
            return false;
        }

        $users = $this->getUsers($user);

        foreach ($users as $user => $credentials) {
            if (
                password_verify($username, reset($credentials)) &&
                password_verify($password, end($credentials))
            ) {
                $this->currentUser = $user;

                return true;
            }
        }

        return false;
    }

    protected function getUsers($user = null)
    {
        if ($user !== null) {
            return array_intersect_key($this->users, array_flip((array) $user));
        }

        return $this->users;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}

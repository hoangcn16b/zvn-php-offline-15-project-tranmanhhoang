<?php

class Auth
{
    public static function checkAuth($user)
    {
        $userInfor = $user;
        $logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
        if ($logged == false) {
            URL::redirectLink('backend', 'index', 'login');
        }
    }
}

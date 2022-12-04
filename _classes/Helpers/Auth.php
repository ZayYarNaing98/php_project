<?php

namespace Helpers;

class Auth
{
    static $loginPath = "/index.php";

    static function check()
    {
        session_start();
        if(isset($_SESSION['user']))
        {
            return $_SESSION['user'];
        }

        HTTP::redirect(static::$loginPath, "login=false");
    }
}

//test5.php
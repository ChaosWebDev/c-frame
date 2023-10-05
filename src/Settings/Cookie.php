<?php

namespace CFW\Settings;

class Cookie
{
    public static function add($title, $value, $expiration)
    {
        setcookie($title, $value, time() + $expiration);
    }

    public static function remove($title)
    {
        setcookie($title, "", time() - 3600);
    }

    public static function kill_all()
    {
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, "", time() - 3600);
        }
    }
}

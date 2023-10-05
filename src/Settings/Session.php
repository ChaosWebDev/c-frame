<?php

namespace CFW\Settings;

class Session
{
    public static function kill_all()
    {
        session_destroy();
        session_reset();
        session_start();
        session_regenerate_id();
    }
}

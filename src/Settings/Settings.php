<?php

namespace CFW\Settings;

class Settings
{
    protected $settings;

    public function __construct()
    {
        $this->get_system_settings();
        $this->get_user_settings();
    }

    public function get_system_settings()
    {
        date_default_timezone_set($_ENV['TIMEZONE'] ?? 'America/Denver');
    }

    public function get_user_settings()
    {
        $_SESSION['settings']['theme'] = $_SESSION['settings']['theme'] ?? $_SESSION['user']['theme'] ?? 'dark';
        if (isset($_SESSION['user']['theme'])) unset($_SESSION['user']['theme']);
    }
}

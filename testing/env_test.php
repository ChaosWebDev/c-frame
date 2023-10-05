<?php

use CFW\System\ENV;

require_once(__DIR__ . '/../vendor/autoload.php');

ENV::load(__DIR__ . "/.env");
pr($_ENV);

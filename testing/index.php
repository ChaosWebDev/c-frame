<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use CFW\System\ENV;
use CFW\Interface\Dispatcher;

ENV::load(__DIR__ . "/.env");

Dispatcher::dispatch(__DIR__ . "/routes/routes.php");
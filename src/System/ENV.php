<?php

namespace CFW\System;

use Exception;

class ENV
{
    public static function load($url)
    {
        if (!file_exists($url)) {
            return throw new Exception("File not found: $url");
        }

        $lines = file($url, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (substr($line, 0, 1) === '#') {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $value = trim($value, "\"");

            $_ENV[$key] = $value;
        }
    }
}

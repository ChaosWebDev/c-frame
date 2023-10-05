<?php

namespace CFW\Traits;

trait Input
{
    public static function validate($var)
    {
        switch ($var) {
            case (is_int($var)):
                $var = Validation::int($var);
                $var = Sanitization::int($var);
                break;
            case (is_float($var)):
                $var = Validation::float($var);
                $var = Sanitization::float($var);
                break;
            case (filter_var($var, FILTER_VALIDATE_EMAIL)):
                $var = filter_var($var, FILTER_VALIDATE_EMAIL);
                break;
            default:
                $var = Sanitization::general($var);
                break;
        }
        return $var;
    }
}

class Validation
{
    public static function int($var)
    {
        return filter_var($var, FILTER_VALIDATE_INT);
    }

    public static function float($var)
    {
        return filter_var($var, FILTER_VALIDATE_FLOAT);
    }

    public static function email($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }
}

class Sanitization
{
    public static function int($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function float($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public static function email($var)
    {
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public static function general($var)
    {
        return htmlentities($var, ENT_QUOTES);
    }
}

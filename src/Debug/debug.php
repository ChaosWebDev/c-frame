<?php

function pr($var)
{
    if (empty($var) || $var == null || $var == '') {
        vd($var);
        return;
    }

    echo "<pre>";
    print_r($var);
    echo "</pre>";
    return;
}

function vd($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    return;
}

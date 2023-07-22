<?php

if (file_exists($file = __DIR__ . '/../vendor/autoload.php')) {
    set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../vendor/phing/phing/classes');

    require_once $file;
}

<?php

require __DIR__ . '/../vendor/autoload.php';
echo class_exists('App\\Config\\Database') ? 'OK' : 'FAIL';

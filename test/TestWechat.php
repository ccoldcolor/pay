<?php

require '../vendor/autoload.php';

use coldcolor\pay\wechat\App;

$m = App::miniprogram111([
    "app_id" => '1234567'
]);

var_dump($m);
<?php

define('ROOT_PATH',dirname(__FILE__));
// run composer autoload
require_once __DIR__ . "/../vendor/autoload.php";

//run the framework
(new Ililuminates\Application)->start();

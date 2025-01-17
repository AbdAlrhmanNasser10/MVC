<?php
// run composer autoload
require_once __DIR__ . "/../vendor/autoload.php";

use Ililuminates\Application;

$application = new Application;

$application->start();


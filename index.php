<?php
include_once("./vendor/autoload.php");
include_once("./App/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$r = new Router();
$r->run();

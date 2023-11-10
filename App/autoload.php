<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['idsUser'])) {
    $_SESSION['idsUser'] = 3;
}

if (!isset($_SESSION['idsFile'])) {
    $_SESSION['idsFile'] = 1;
}

require_once("config.php");
require_once("Router.php");
require_once("Core/Controller.php");
require_once("Models/User.php");

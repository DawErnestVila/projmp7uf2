<?php
require_once("Orm.php");

class User extends Orm{
    public function __construct()
    {
        parent::__construct('users');
    }
}

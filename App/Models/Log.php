<?php
require_once("Orm.php");

class Log extends Orm
{
    public function __construct()
    {
        parent::__construct('logs');
    }
}

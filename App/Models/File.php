<?php
require_once("Orm.php");

class File extends Orm
{
    public function __construct()
    {
        parent::__construct('files');
    }
}

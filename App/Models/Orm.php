<?php
class Orm
{

    protected $model;

    public function __construct($model)
    {

        $this->model = $model;
        if (!isset($_SESSION[$this->model])) {
            $_SESSION[$this->model] = [];
        }
    }

    public function getById($id)
    {
        foreach ($_SESSION[$this->model] as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function getByUsername($username)
    {
        foreach ($_SESSION[$this->model] as $item) {
            if ($item['username'] == $username) {
                return $item;
            }
        }
        return null;
    }

    public function getByName($username)
    {
        foreach ($_SESSION[$this->model] as $item) {
            if ($item['name'] == $username) {
                return $item;
            }
        }
        return null;
    }

    public function getAll()
    {
        return $_SESSION[$this->model];
    }

    public function store($item)
    {
        $_SESSION[$this->model][] = $item;
    }

    public function delete($id)
    {
        foreach ($_SESSION[$this->model] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION[$this->model][$key]);
                return $item;
            }
        }
        return null;
    }

    public function update($data)
    {
        foreach ($_SESSION[$this->model] as $key => $item) {
            if ($item['id'] == $data['id']) {
                $_SESSION[$this->model][$key] = $data;
                return true;
            }
        }
        return false;
    }
}

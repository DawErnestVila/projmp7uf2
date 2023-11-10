<?php
class Router
{

    private $controller;
    private $method;

    public function __construct()
    {
        $this->matchRoute();
    }

    public function matchRoute()
    {
        $rutes = array(
            "/home",
            "main/home",
            "main/reset",
            //"main/err404",
            "user/main",
            "user/create",
            "user/login",
            "user/store",
            "user/verify",
            "user/checklogin",
            "user/logOut",
            "user/sendMail",
            "user/admin",
            "user/delete",
            "user/update",
            "user/checkUpdate",
            "user/logs",
            "file/store",
            "file/delete",
            "file/download",
            "file/share",
            "file/shareWith",
        );
        $url = explode('/', URL);
        $this->controller = !empty($url[1]) ? $url[1] : 'main';
        $this->controller = $this->controller . 'Controller';
        $this->method = !empty($url[2]) ? $url[2] : 'home';

        $trobat = false;
        foreach ($rutes as $ruta) {

            if ($ruta == $url[1] . "/" . $this->method) {
                require_once("App/Controllers/" . $this->controller . ".php");
                $trobat = true;
                break;
            }
        }
        if (!$trobat) {
            $this->controller = 'mainController';
            $this->method = 'err404';
            require_once("App/Controllers/" . $this->controller . ".php");
        }
    }

    public function run()
    {
        $controller = new $this->controller();
        $method = $this->method;
        $controller->$method();
    }
}

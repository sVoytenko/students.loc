<?php

/*
 * Решил роутер вынести отдельно. 
 */

class Router
{

    protected $controller = "IndexController";
    protected $action = "actionIndex";

    public function __construct()
    {
        //получине урла
        $uri = trim(htmlspecialchars($_SERVER['REQUEST_URI']), "/");
        //если по ссылке передаются параметры - урл обрезается до знака вопроса
        if ($uri[0] == "?") {
            $uri = "";
        } elseif (strpos($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }
        $arr = explode("/", $uri);
        if (count($arr) == 1 && $arr[0] != "index") {
            if (class_exists("Controllers\\" . $arr[0] . "Controller")) {
                $this->controller = $arr[0] . "Controller";
            } else {
                $this->action = !empty($arr[0]) ? "action" . $arr[0] : "actionIndex";
            }
        }
        if (count($arr) == 2 && $arr[0] != "index") {
            if (class_exists("Controllers\\" . $arr[0] . "Controller")) {
                $this->controller = $arr[0] . "Controller";
                $this->action = "action" . $arr[1];
            } else {
                $this->action = "action404";
            }
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name))
            return $this->$name;
    }

    /* методс возвращает обьект-контроллер */

    public function getController()
    {
        $c = "Controllers\\" . $this->controller;
        if (class_exists($c)) {
            return new $c;
        } else {
            $this->action = "action404";
            return new Controllers\IndexController();
        }
    }

}

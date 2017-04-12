<?php

namespace Controllers;
/**Класс для наследоания, в котором реализованы основные методы и параметры для любого контроллера
 * Решил реализовать так во-первых потому, что если делать это все в одном контроллере -
 * его код разрастается до неприличя, во-вторых - на случай расширения приложения.
 **/
abstract class BaseConttoller
{

    protected $view;
    protected $gateaway;
//загрузка зависимостей
    public function __construct()
    {
        $this->view = new \View();
        $this->gateaway = new \models\StudentsGateaway('../db config.ini');
    }
//запуск контроллера
    public function run($action)
    {
        if (method_exists($this, $action)) {
            $this->$action();
        } elseif (empty($action)) {
            $this->actionIndex();
        } else {
            $this->action404();
        }
    }
//индекс и 404 - базовые экшены
    protected function actionIndex()
    {
        
    }

    protected function action404()
    {
        $this->view->display("404");
    }

}

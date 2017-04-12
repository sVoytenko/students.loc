<?php
/* класс дла загрузки шаблонов, возможно еще что-то допишу в нем */
class View
{

    public function display($template, $model = null, $data = null)
    {
        require_once "templates/" . $template . ".html.php";
    }

}

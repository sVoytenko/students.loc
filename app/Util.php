<?php

/**
 * класс для различных статических методов
 */
class Util
{
    /* генерация пароля */

    public static function generatePassword()
    {
        $string = "qwertyuiopasdfghjklzxcvbnm0123456789";
        $pass;
        $count = mb_strlen($string);
        for ($i = 0; $i < 8; $i++) {
            $char = mb_substr($string, rand(0, $count), 1);
            $pass .= $char;
        }
        return $pass;
    }

    /* получение ссылки без сортировки */

    public static function getUnsortedLink()
    {
        $page = array_key_exists('page', $_GET) ? htmlspecialchars($_GET['page']) : '1';
        return $link = '&' . http_build_query(['page' => $page]);
    }

    /* получиние ссылки с сортировков */

    public static function getSortedLink($page)
    {
        $sort = array_key_exists('sort', $_GET) ? htmlspecialchars($_GET['sort']) : 'name';
        return $link = '?' . http_build_query(['sort' => $sort, 'page' => $page]);
    }

    public static function checkOrderField($sort)
    {
        $fields = array('name', 'second_name', 'group_number', 'summary');
        $sth;
        foreach ($fields as $field) {
            if ($sort == $field) $sth = $field;
        }
        if($sth == $sort){
            return $sth;
        } else {
            return 'name';
        }
    }

}

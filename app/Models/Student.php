<?php

namespace models;
/*
 * модель студента
 */
class Student
{

    public $name;
    public $secondName;
    public $groupNumber;
    public $gender;
    public $birthYear;
    public $summary;
    public $local;
    public $email;
    public $password;
/*
 * Не уверен что это правильно, но мне кажется с помощью set-get намного удобней делать
 * присваивания параметров класса если их много
 */
 
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
//это наверное надо поправить - сделал так из-за того, что в БД поля так называются
        switch ($name) {
            case 'second_name':
                $this->secondName = $value;
            case 'group_number':
                $this->groupNumber = $value;
            case 'birth_year':
                $this->birthYear = $value;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        switch ($name) {
            case 'second_name':
                return $this->secondName;
            case 'group_number':
                return $this->groupNumber;
            case 'birth_year':
                return $this->birthYear;
        }
    }

    public function __isset($name)
    {
        return isset($name);
    }
// тоже решил все засунуть в модель, что бы не копипастить код
    public function map(array $post)
    {
        $this->name = trim(htmlspecialchars($_POST['name']));
        $this->secondName = trim(htmlspecialchars($_POST['second_name']));
        $this->birthYear = trim(htmlspecialchars($_POST['birth_year']));
        $this->email = trim(htmlspecialchars($_POST['email']));
        $this->groupNumber = trim(htmlspecialchars($_POST['group_number']));
        $this->local = trim(htmlspecialchars($_POST['local']));
        $this->gender = trim(htmlspecialchars($_POST['gender']));
        $this->summary = trim(htmlspecialchars($_POST['sumary']));
        $this->password = \Util::generatePassword();
    }

}

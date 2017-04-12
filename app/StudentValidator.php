<?php

/*
 * класс для валидации модели студента.
 * Не уверен, что правильно выбрал подход вида 
 *  if(mb_strlen($student->name) > 10 ) $errorMsg .= " Длинна..
*/

class StudentValidator
{

    public function validate(\models\Student $student, models\StudentsGateaway $gateaway, $id = 0)
    {
        $errors = array();
        if (!preg_match("/^[а-яА-Яa-zA-Z-']{1,10}$/u", $student->name)) {
            $errorMsg = 'Вы ввели некоректный формат имени!';
            if (mb_strlen($student->name) > 10) $errorMsg .= " Длинна имени не должна превышать 10 символов!";
            $errors['name'] = $errorMsg;
        }
        if (!preg_match("/^[а-яА-Яa-zA-Z-']{1,20}$/u", $student->secondName)) {
            $errorMsg = 'Вы ввели неправильный формат фамилии!';
            if (mb_strlen($student->secondName) > 20) $errorMsg .= ' Длинна не должна превышать 20 символов!';
            $errors['secondName'] = $errorMsg;
        }
        if (!preg_match("/^[0-9]{1,5}$/", $student->groupNumber)) {
            $errors['group'] = 'Вы ввели некоректный формат группы!';
        }
        if (!preg_match("/^[0-9]{4,5}$/", $student->birthYear)) {
            $errors['birthYear'] = 'Вы ввели некоректный формат года рождения!';
        }
        if (!preg_match("/^[0-9]{1,3}$/", $student->summary)) {
            $errors['summary'] = 'Вы ввели некоректный формат баллов!';
        }
        if (!filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Вы ввели некоректный формат почтового адреса!';     
        }
        if(empty($id)){
            if($gateaway->checkEmailUniqueness($student->email)){
                $errors['email'] .= ' Ваш почтовый адрес уже зарегистрирован!';
            }
        }else{
            if($gateaway->checkEmailUniquenessForUpdate($student->email, $id)){
                $errors['email'] .= ' Ваш почтовый адрес уже зарегистрирован!';
            }
        }

        return $errors;
    }

}

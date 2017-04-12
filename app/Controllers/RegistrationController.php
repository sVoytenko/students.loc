<?php

namespace Controllers;

/**
 * контроллер для регистрации
 */
class RegistrationController extends \Controllers\BaseConttoller
{

    public function __construct()
    {
        parent::__construct();
    }
/* Страница при отправке формы перенаправляет на себя же.
 * Если форма отправлена - производится валидация, в случае успеха - данные
 * добавляются в базу, устанавливаются куки и идет переадресация на заглавную страницу
 */
    public function actionIndex()
    {
        $student = new \models\Student();
        if (!empty($_POST)) {
            $student->map($_POST);
            $validator = new \StudentValidator();
            $errors = $validator->validate($student, $this->gateaway);
            if (empty($errors)) {
                $this->gateaway->addStudent($student);
                $id = $this->gateaway->getLastId();
                setcookie('id', $id, time() + 360000, '/');
                setcookie('name', $student->name, time() + 360000, '/');
                setcookie('password', $student->password, time() + 360000, '/');
                $link = '\?notify=registered';
                header('Location: ' . $link);
                die();
            } else {
                $data['errors'] = $errors;
                $data['action'] = 'registration';
                $this->view->display('registration', $student, $data);
            }
        } else {
            $this->view->display('registration', $model);
        }
    }

}

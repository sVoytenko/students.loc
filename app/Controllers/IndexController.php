<?php

namespace Controllers;
//контроллер для заглавной страницы
class IndexController extends BaseConttoller
{


    public function __construct()
    {
        parent::__construct();
        $id = htmlspecialchars($_COOKIE['id']);
        $password = htmlspecialchars($_COOKIE['password']);
        //проверка наличия куки пользователя, если нет - переадресация на страницу регистрации
        $id = htmlspecialchars($_COOKIE['id']);
        $password = htmlspecialchars($_COOKIE['password']);
        if (!$this->gateaway->checkUserExists($id, $password)) {
            header('Location: /registration/');
        }
    }
/* Экшен заглавной страницы. Из адресной строки получаются данные для пагинации,
 * если их нет - выставляются значения по умолчанию и передаюся в класс для расчета пагинации
 * */
    protected function actionIndex()
    {
        $limit = 5;
        $currentPage = array_key_exists('page', $_GET) ? htmlspecialchars($_GET['page']) : NULL;
        $pager = new \Paginator($currentPage, $this->gateaway->getCount(), $limit);
        $startPage = $pager->startPage;
        $sort = array_key_exists('sort', $_GET) ? htmlspecialchars($_GET['sort']) : 'name';
        $students = $this->gateaway->getAll($sort, $startPage, $limit);
        $data['title'] = 'Список студентов';
        $data['totalPages'] = $pager->totalPages;
        if (isset($_GET['notify'])) $data['notify'] = TRUE;
        $this->view->display('index', $students, $data);
    }
/* экшен для поиска */
    protected function actionSearch()
    {
        $search = htmlspecialchars($_GET['s']);
        $model = $this->gateaway->search($search, 'name', 0, 10);
        $this->view->display('search', $model);
    }
/* экшен для обновления данных */
    protected function actionUpdate()
    {
        if(empty($_POST)){
           $id = htmlspecialchars($_COOKIE['id']);
           $password = htmlspecialchars($_COOKIE['password']);
           $student = $this->gateaway->getStudent($password, $id);
           $this->view->display('registration', $student);
        } else {
           $id = htmlspecialchars($_COOKIE['id']);
           $student = new \models\Student();
           $student->map($_POST);
           $validator = new \StudentValidator();
           $data['errors'] = $validator->validate($student, $this->gateaway, $id);
           if(empty($data['errors'])){
               $this->gateaway->update($id, $student);
               header("Location: /update/");
           } else {
               $this->view->display('registration', $student, $data);
           }
           
        }
    }

}

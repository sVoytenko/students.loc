<?php

namespace models;

/**
 * Класс для таблицы students, реализующий паттерн TableDataGateaway
 */
class StudentsGateaway
{

    protected $dbh;

    public function __construct($DbConfigPath)
    {
        $settings = parse_ini_file($DbConfigPath);
        $dsn = "mysql:host={$settings['host']};dbname={$settings['dbname']}";
        $username = $settings['user'];
        $password = $settings['password'];
        $this->dbh = new \PDO($dsn, $username, $password);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /*
     * добавляет новую запись в таблицу.
     */

    public function addStudent(Student $student)
    {
        $params = array($student->name, $student->secondName, $student->gender, $student->groupNumber, $student->birthYear, $student->summary, $student->email, $student->local, $student->password);
        $query = 'INSERT INTO 
                 students(name, second_name, gender, group_number, 
                 birth_year, summary, email, local, password)
                 VALUES
                 (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($params);
    }

    public function getLastId()
    {
        return $this->dbh->lastInsertId();
    }

//возвращает запись из таблицы по паролю и идентификатору
    public function getStudent($password, $id)
    {
        $sql = "SELECT 
                name, second_name, group_number, summary, gender, birth_year, email, local
                FROM 
                students WHERE password = :password AND id = :id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':password', $password);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchObject('models\Student');
    }

//возвращает все записи из таблицы с сортировкой и лимитом
    public function getAll($sort, $start, $limit)
    {
        $orderField = \Util::checkOrderField($sort);
        $sql = "SELECT 
                name, second_name, group_number, summary
                FROM 
                students
                ORDER BY " . $orderField . " LIMIT :start, :limit";
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(":start", $start);
        $sth->bindValue(":limit", $limit);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS, 'models\Student');
    }

    /* поиск */

    public function search($search, $sort, $start, $limit)
    {
        $orderField = \Util::checkOrderField($sort);
        $sql = "SELECT
                name, second_name, group_number, summary
                FROM 
                students
                WHERE 
                :search IN(name, second_name, group_number, summary) 
                ORDER BY " . $orderField . " 
                LIMIT :start, :limit";
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':search', $search);
        $sth->bindValue(':start', $start);
        $sth->bindValue(':limit', $limit);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS, 'models\Student');
    }

//обновляет данные в таблице 
    public function update($id, Student $student)
    {
        $params = array($student->name, $student->secondName, $student->gender, $student->groupNumber, $student->birthYear, $student->summary, $student->email, $student->local, $id);
        $sql = "UPDATE 
               students
               SET 
               name=?,second_name=?, gender = ?, group_number = ?, 
               birth_year = ?, summary = ?, email = ?, local = ?
               WHERE 
               id = ?";
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
    }

    public function getCount()
    {
        $sql = "SELECT COUNT(*) FROM students";
        $stmt = $this->dbh->query($sql);
        return $stmt->fetchColumn();
    }

    public function getCountBySearch($search)
    {
        if (empty($search)) return 0;
        $sql = "SELECT COUNT(*) FROM 
                students 
                WHERE 
                " . $search . "
                IN
                (name, second_name, group_number, summary)";
        $stmt = $this->dbh->query($sql);
        return $stmt->fetchColumn();
    }

    public function checkEmailUniqueness($email)
    {
        $sql = "SELECT COUNT(id) FROM students WHERE email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
        public function checkEmailUniquenessForUpdate($email, $id)
    {
        $sql = "SELECT COUNT(id) FROM students WHERE email = :email AND NOT id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function checkUserExists($id, $password)
    {
        $sql = "SELECT COUNT(id) FROM students WHERE id=:id AND password = :password";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

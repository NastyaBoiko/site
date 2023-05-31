<?php

// $sql = ['localhost', 'root', 'root', 'site'];

class MySql extends mysqli
{
    public $isConnected = false;

    public function __construct($mas) {

        // Конструкция лист очень красиво! Но не работает без написания ключей
        list('hostname' => $host, 'username' => $user, 'password' => $pass, 'database' => $db) = $mas;

        // $host = $mas['hostname'];
        // $user = $mas['username'];
        // $pass = $mas['password'];
        // $db = $mas['database'];

        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        parent::__construct($host, $user, $pass, $db);

        if (!$this->connect_errno) {
            $this->isConnected = true;
        }
        // var_dump($this->isConnected);
    }

    public function querySelect($quest) {
        $result = $this->query($quest); //заменен с parent:: без проверки
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isUnique($tableName, $tableField, $searchField) {
        //Проверка есть ли подключение сделать true - уникальное
        $val = $this->isConnected ? empty($this->querySelect("SELECT * FROM $tableName WHERE `$tableField` = '$searchField'")) : 'error';
        return $val;
    }

}

// echo '<pre>';
// $mysql = new MySql($sql);


// $result = $mysql->isUnique('role', 'title', 'Author2');

// var_dump($result);

// $rows = $mysql->ask("SELECT title FROM role ORDER BY id ASC");



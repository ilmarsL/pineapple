<?php

class Dbh {
    private $host = 'localhost';
    private $user = '';
    private $pwd = '';
    private $dbname = 'pineapple';

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        return $pdo;
    }
}
<?php

class Model {

    public  $mysqli;
    
    public function __construct()
    {
        $db_hostname = DB_HOST;
        $db_database = DB_NAME;
        $db_username = DB_USER;
        $db_password = DB_PASS;

        $mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        if (!$mysqli) {
            printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        $this->mysqli = $mysqli;

        $this->mysqli->query('SET NAMES "UTF-8"');

        $query = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(255),
        age INT,
        info TEXT,
        photo VARCHAR(255)
        )";

        mysqli_query($mysqli, $query);
    }
}
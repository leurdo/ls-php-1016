<?php

class Model_Main extends Model {

    public function put_data_reg($username, $password)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $password);
        $ok = $stmt->execute();

        if ($ok) {
           return $this->check_data_reg($username, $password);
        }
        return false;
    }

    public function check_data_reg($username, $password)
    {
        $stmt = $this->mysqli->prepare("SELECT * from users WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        $record = $result->fetch_assoc();

        if ($record) {
            return $record['id'];

        } else {
            return false;
        }
    }

}
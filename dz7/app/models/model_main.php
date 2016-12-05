<?php

class Model_Main extends Model {

    public function put_data_reg($username, $password)
    {

        $id = User::insertGetId(
            array('username' => $username, 'password' => $password, 'ip' => $_SERVER['REMOTE_ADDR'])
        );

        if ($id) {
           return $this->check_data_reg($username, $password);
        }
        return false;
    }

    public function check_data_reg($username, $password)
    {
        $matchThese = array('username' => $username, 'password' => $password);
        $id = User::where($matchThese)->pluck('id')->toArray();
        $id = (int)implode('', $id);

        if ($id) {
            return $id;

        } else {
            return false;
        }
    }

}
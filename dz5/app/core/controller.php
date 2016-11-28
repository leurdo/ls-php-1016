<?php

class Controller {

    public $model;
    public $view;
    public $uploaddir = PHOTO_PATH;

    function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

    function action_index(){

    }

    public function isLogin()
    {
        if (isset($_SESSION['id'])) {
            return true;
        }

        return false;

    }

    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        }
        return false;
    }

    public function exitAccount()
    {
        session_unset();
        header('Location: /');
        exit;
    }

}
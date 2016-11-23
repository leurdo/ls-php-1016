<?php
class Controller_Main extends Controller {

    function __construct()
    {
        $this->model  =  new Model_Main();
        $this->view = new View();

    }

    public function action_index()
    {
        session_start();

        if (!$this->isLogin()) {
            if ($this->isPost()) {
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));

                if ($_POST['registration']) {
                    $data = $this->user_registration($username, $password);
                    if ($this->isLogin()) {
                        header('Location: account');
                    }

                } else {
                    $data = $this->user_login($username, $password);
                    if ($this->isLogin()) {
                        header('Location: account');
                    }
                }
            }
        } else {
            header('Location: account');
        }
        $this->view->generate('template_view.php', 'main_view.php', $data);
    }

    protected function user_registration($username, $password)
    {

                $username = htmlspecialchars(strip_tags($username));
                $password = htmlspecialchars(strip_tags($password));

                $id = $this->model->put_data_reg($username, $password);

                if ($id) {
                    $_SESSION['id'] = $id;
                    return $_SESSION['id'];

                } else {
                    return 'Что-то пошло не так';
                }

    }

    protected function user_login($username, $password)
    {
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password));

        $id = $this->model->check_data_reg($username, $password);

        if ($id) {
            $_SESSION['id'] = $id;
            return $_SESSION['id'];
        } else {
            return 'Логин или пароль неправильные';
        }
    }

}
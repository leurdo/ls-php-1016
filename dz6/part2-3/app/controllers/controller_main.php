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
                $captcha = $_POST['g-recaptcha-response'];

                if ($this->get_captcha_response($captcha)) {
                    if ($_POST['registration']) {
                        $data = $this->user_registration($username, $password);
                        if ($this->isLogin() && !$data) {
                            header('Location: account');
                        }

                    } else {
                        $data = $this->user_login($username, $password);
                        if ($this->isLogin()) {
                            header('Location: account');
                        }
                    }
                } else {
                    $data = 'Капча введена неверно';
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
                    return ($this->user_sendmail($username, $password));

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

    protected function user_sendmail($username, $password)
    {
        require_once 'app/vendor/autoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'missis.leurdo2017';                 // SMTP username
        $mail->Password = 'leurdo';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'utf-8';

        $mail->setFrom('missis.leurdo2017@yandex.ru', 'Mailer');
        $mail->addAddress('katya.leurdo@gmail.com', 'Katya User');     // Add a recipient
        $mail->addReplyTo('missis.leurdo2017@yandex.ru', 'Information');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Письмо от системы регистрации';
        $mail->Body    = 'Спасибо за регистрацию! Ваш логин: ' . $username . ' Ваш пароль: ' . $password;

        if(!$mail->send()) {
            return 'Вы зарегистрированы, но сообщение не отправлено. Ошибка: ' . $mail->ErrorInfo;
        } else {
            return false;
        }
    }

    protected function get_captcha_response($captcha)
    {
        $rUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $rSecret = '6LfiRw0UAAAAAH_3_eB31u2_KhEqB4LVHVhb2pur';
        $ip = $_SERVER['REMOTE_ADDR'];

        $curl = curl_init($rUrl);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret='.$rSecret.'&response='.$captcha.'&remoteip='.$ip);
        curl_setopt($curl, CURLINFO_HEADER_OUT, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($res);

        if ($res->success) {
            return true;
        } else {
            return false;
        }
    }

}
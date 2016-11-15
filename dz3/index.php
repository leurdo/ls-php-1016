<?php
require_once 'connect.php';
session_start();
$badinput = false;

if (empty($_SESSION['id'])) {

    if ($_POST['send']) {

        $username = htmlspecialchars(strip_tags($_POST['username']));
        $password = htmlspecialchars(strip_tags($_POST['password']));

        if ($_POST['registration']) {

            $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();

            $_SESSION['registered'] = 'OK';
            header('Location: index.php');
            exit;

        } else {
            $stmt = $mysqli->prepare("SELECT * from users WHERE username = ? AND password = ?");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();

            $result = $stmt->get_result();
            $record = $result->fetch_assoc();

            if ($record) {
                $_SESSION['id'] = $record['id'];
                header('Location: account.php');
            } else {
                $badinput = true;
            }

        }

    }
} else {
    header('Location: account.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>LsPhp2016-Homework3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1 class="text-center">Домашнее задание №3</h1>
    <h3>Это - форма авторизации. Если Вы хотите зарегистрироваться, поставьте галочку в чекбоксе.</h3>
    <div class="col-md-6">
        <form method="post" id="autorization_form" action="">
            <div class="form-group">
                <label for="username">Ваш логин</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Введите логин">
            </div>
            <div class="form-group">
                <label for="password">Ваш пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="registration"> Зарегистрируйте меня!
                </label>
            </div>
            <input type="submit" name="send" class="btn btn-default" value="Отправить">
        </form>
    </div>
    <div class="col-md-6">
        <?php
        if ($_SESSION['registered'] == 'OK') {
            echo '<p>Спасибо за регистрацию! Теперь вы можете авторизоваться, используя данные, указанные при регистрации.</p>';
            $_SESSION['registered'] = 'NOT';
        }
        if ($badinput) {
            echo '<p>Укажите корректные данные или воспользуйтесь регистрацией!</p>';
        }
        ?>
    </div>


</div>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>LsPhp2016-Homework8</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1 class="text-center">Домашнее задание №8</h1>

    <div class="col-md-6">
        <form method="post" action="controller.php">
            <div class="form-group">
                <label for="wall">Кому бы запостить котиков? Введите id пользователя</label>
                <input type="text" class="form-control" id="wall" name="wall">
            </div>
            <input type="submit" name="submit" class="btn btn-default" value="Отправить">
        </form>
    </div>
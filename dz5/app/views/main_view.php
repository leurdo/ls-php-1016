<h1 class="text-center">Домашнее задание №5</h1>
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
    <?php echo $data; ?>
</div>
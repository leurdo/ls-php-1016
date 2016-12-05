<h1 class="text-center">Домашнее задание №6</h1>
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
        <div class="form-group">
            <label for="email">Куда прислать сообщение о регистрации?</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Введите емейл">
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="registration"> Зарегистрируйте меня!
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LfiRw0UAAAAALa-82pFyXVxdmTlIexHr9dQ2ljU"></div>
        </div>
        <input type="submit" name="send" class="btn btn-default" value="Отправить">
    </form>
</div>
<div class="col-md-6">
    <?php echo $data; ?>
</div>
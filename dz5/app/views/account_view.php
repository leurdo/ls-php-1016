<h1 class="text-center">Домашнее задание №5</h1>
<div class="col-md-6">
    <h3>Здесь у нас вводятся данные пользователя</h3>
    <form method="post" id="account_form" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Ваше имя</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']; ?>" placeholder="Введите имя">
        </div>
        <div class="form-group">
            <label for="age">Ваш возраст</label>
            <input type="text" class="form-control" id="age" name="age" value="<?php echo $data['age']; ?>" placeholder="Введите возраст">
        </div>
        <div class="form-group">
            <label for="info">Расскажите о себе</label>
            <textarea class="form-control" id="info" name="info" placeholder="Информация о вас"><?php echo $data['info']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="info">Добавьте Вашу фотографию</label>
            <input type="file" class="form-control" id="userpic" name="userpic" placeholder="Загрузите фото">
            <p><?php echo $data['error']; ?></p>
            <?php echo $data['photo']; ?>
        </div>
        <input type="submit" name="infosend" class="btn btn-default" value="Отправить">
        <input type="submit" name="quit" class="btn btn-default" value="Выйти из аккаунта">
    </form>
</div>
<div class="col-md-6">
    <h3>А здесь у нас список всех загруженных картинок</h3>
    <form method="post" id="admin_form" action="">
        <table class="table">
            <tr><th>Превью</th><th>Название</th><th>Удалить?</th></tr>
            <?php foreach ($data['photolist'] as $photo): ?>
            <tr><td><?php echo $photo['img']; ?></td><td><input type="text" class="form-control" name="<?php echo $photo['photoname']; ?>" value="<?php echo $photo['photoname']; ?>"></td><td><input type="checkbox" class="form-control" name="<?php echo $photo['photoname']; ?>-del"></td></tr>
            <?php endforeach; ?>
        </table>
        <input type="submit" name="adminsend" class="btn btn-default" value="Сохранить">
    </form>
    <p><?php echo $data['list_error']; ?></p>
</div>
<?php

require_once 'connect.php';
session_start();
$uploaddir = 'photos';
$img_ext = array('jpg', 'png', 'jpeg', 'gif', 'svg');

if (!empty($_SESSION['id'])) {

    if ($_POST['quit']) {
        $_SESSION['id'] = '';
        header('Location: index.php');
        exit;
    }

    if ($_POST['infosend']) {
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $age = htmlspecialchars(strip_tags($_POST['age']));
        $info = htmlspecialchars(strip_tags($_POST['info']));

        $file = $_FILES['userpic'];

        if ($file['name']) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo 'Ошибка! Не удалось загрузить файл! ' . $file['error'];
                exit;
            }
            $ext = pathinfo($file['name']);
            $filename = $file['name'];
            $filetype = $file['type'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $img_ext)) {
                echo 'Файл, который вы пытаетесь загрузить, не является картинкой!';
                exit;
            }

            $img_mime = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml');
            if (!in_array($filetype, $img_mime)) {
                echo 'Файл, который вы пытаетесь загрузить, не является картинкой!';
                exit;
            }

            $newfilename = time() . '-' . $filename;

            move_uploaded_file($file['tmp_name'], "$uploaddir/$newfilename");

            $sql = "UPDATE users SET name = ?, age = ?, info = ?, photo = ? WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('sissi', $name, $age, $info, $newfilename, $_SESSION['id']);
                $stmt->execute();
            }

        } else {
            $sql = "UPDATE users SET name = ?, age = ?, info = ? WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('sisi', $name, $age, $info, $_SESSION['id']);
                $stmt->execute();
            }
        }



    }

    function PrintFileList($uploaddir, $img_ext)
    {
        $photos = scandir($uploaddir);
        $photolist = '<form method="post" id="admin_form" action="">';
        $photolist .= '<table class="table">';
        $photolist .= '<tr><th>Превью</th><th>Название</th><th>Удалить?</th></tr>';

        foreach ($photos as $photo) {
            if (!in_array($photo, array('.', '..'))) {
                $photoname = pathinfo($photo, PATHINFO_FILENAME);
                $photoext = pathinfo($photo, PATHINFO_EXTENSION);
                if (in_array($photoext, $img_ext)) {
                    $photolist .= '<tr><td><img src="' . $uploaddir . '/' . $photo . '" height="100px"></td>';
                    $photolist .= '<td><input type="text" class="form-control" name="' . $photoname . '" value="' . $photoname . '"></td>';
                    $photolist .= '<td><input type="checkbox" class="form-control" name="' . $photoname . '-del"></td></tr>';
                }
            }
        }

        $photolist .= '</table>';
        $photolist .= '<input type="submit" name="adminsend" class="btn btn-default" value="Сохранить">';
        $photolist .= '</form>';

        return $photolist;
    }

    if ($_POST['adminsend']) {
        $photos = scandir($uploaddir);

        foreach ($photos as $photo) {
            if ($photo !== '.' && $photo !== '..') {
                $photoname = pathinfo($photo, PATHINFO_FILENAME);
                $photoext = pathinfo($photo, PATHINFO_EXTENSION);
                $newphotoname = strip_tags($_POST[$photoname]) . '.' . $photoext;
                $delete = $_POST[$photoname . '-del'];

                if ($delete) {
                    unlink("$uploaddir/$photo");
                    $newphotoname = NULL;
                } elseif ($newphotoname !== $photo) {
                    rename("$uploaddir/$photo", "$uploaddir/$newphotoname");
                }

                $sql = "UPDATE users SET photo = ? WHERE photo = ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param('ss', $newphotoname, $photo);
                    $stmt->execute();
                }

                header('Location: account.php');
            }
        }
    }

    $stmt = $mysqli->prepare("SELECT * from users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $record = $result->fetch_assoc();

    if ($record) {
        $name = $record['name'];
        $age = $record['age'];
        $info = $record['info'];
        $file = ($record['photo'] == NULL) ? '' : $record['photo'];
        $fileoutput = $file ? '<p>Ваша фотография:' . $file . '</p><img src="' . $uploaddir . '/' . $file . '" height="100px">' : '';
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

    <div class="col-md-6">
        <h3>Здесь у нас вводятся данные пользователя</h3>
        <form method="post" id="account_form" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Ваше имя</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="Введите имя">
            </div>
            <div class="form-group">
                <label for="age">Ваш возраст</label>
                <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>" placeholder="Введите возраст">
            </div>
            <div class="form-group">
                <label for="info">Расскажите о себе</label>
                <textarea class="form-control" id="info" name="info" placeholder="Информация о вас"><?php echo $info; ?></textarea>
            </div>
            <div class="form-group">
                <label for="info">Добавьте Вашу фотографию</label>
                <input type="file" class="form-control" id="userpic" name="userpic" placeholder="Загрузите фото">
                <?php echo $fileoutput; ?>
            </div>
            <input type="submit" name="infosend" class="btn btn-default" value="Отправить">
            <input type="submit" name="quit" class="btn btn-default" value="Выйти из аккаунта">
        </form>
    </div>
    <div class="col-md-6">
        <h3>А здесь у нас список всех загруженных картинок</h3>
        <?php echo PrintFileList($uploaddir, $img_ext); ?>
    </div>
</div>
</body>
</html>
<?php } else {
    header('Location: index.php');
} ?>
<?php
    $image = htmlspecialchars(strip_tags($_POST['image']));
    $token = 'Здесь нужно написать токен';
    $user_id = htmlspecialchars(strip_tags($_POST['wall']));;
    // Игорь Твердохлеб 510101


function GET($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $result=curl_exec($ch);
    curl_close($ch);

    return $result;
}

function getUploadServer($token, $user_id)
{
    $url = 'https://api.vk.com/method/photos.getWallUploadServer?access_token=' . $token;
    $response = GET($url);
    $response = json_decode($response);
    return $response->response->upload_url;
}

function uploadFile($upload_url, $file_path)
{
    $ch = curl_init($upload_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $cfile = curl_file_create(realpath($file_path), 'image/png', 'image.png');
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo' => $cfile));
    $response = curl_exec($ch);
    if ($response === FALSE) {

        echo "cURL Error: " . curl_error($ch);

    }
    curl_close($ch);
    return json_decode($response);
}

function postToWall($token, $user_id, $photo, $server, $hash)
{
    $url = 'https://api.vk.com/method/photos.saveWallPhoto?user_id='.$user_id.'&photo='.$photo.'&server='.$server.'&hash='.$hash.'&access_token='.$token;
    $response = GET($url);
    return $response;
}

function publicate($token, $id)
{
    $url = 'https://api.vk.com/method/wall.post?attachments='.$id.'&access_token='.$token;
    $response = GET($url);
    return $response;
}

$upload_url = getUploadServer($token, $user_id);
$upload_result = uploadFile($upload_url, 'image.png');
$photo_striped = stripslashes($upload_result->photo);
$result = postToWall($token, $user_id, $upload_result->photo, $upload_result->server, $upload_result->hash);
$result = json_decode($result);
$result = $result->response;
//var_dump($result[0]->id);
$posted = publicate($token, $result[0]->id);
echo 'Картинка успешно загружена. Ее id:'.$posted;

?>

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
        <form method="post" action="">
            <div class="form-group">
                <label for="wall">Кому бы запостить котиков? Введите id пользователя</label>
                <input type="text" class="form-control" id="wall" name="wall">
            </div>
            <input type="submit" name="submit" class="btn btn-default" value="Отправить">
        </form>
    </div>
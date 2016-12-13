<?php
$token = 'f244bd3c2c9112b42e9ea9753e70fa3cfd4323c667a4fc00adeaff2f81503c3a3d05ec9e3181d67a2b8d9';
$image = htmlspecialchars(strip_tags($_POST['image']));
$user_id = htmlspecialchars(strip_tags($_POST['wall']));


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
    $url = 'https://api.vk.com/method/photos.getWallUploadServer?owner_id='.$user_id.'&access_token=' . $token;
    $response = GET($url);
    $response = json_decode($response);
    //print_r($response);
    return $response->response->upload_url;
}

function uploadFile($upload_url, $file_path)
{
    $ch = curl_init($upload_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $cfile = curl_file_create(getcwd().'/'.$file_path, 'image/png', 'image.png');
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
    $url = 'https://api.vk.com/method/photos.saveWallPhoto?owner_id='.$user_id.'&photo='.$photo.'&server='.$server.'&hash='.$hash.'&access_token='.$token;
    $response = GET($url);
    return $response;
}

function publicate($token, $user_id, $id, $hash)
{
    $url = 'https://api.vk.com/method/wall.post?owner_id='.$user_id.'&attachments='.$id.'&hash='.$hash.'&access_token='.$token;
    $response = GET($url);
    return $response;
}

$upload_url = getUploadServer($token, $user_id);
$upload_result = uploadFile($upload_url, 'image.png');
$photo_striped = stripslashes($upload_result->photo);
$result = postToWall($token, $user_id, $upload_result->photo, $upload_result->server, $upload_result->hash);
$result = json_decode($result);
$result = $result->response;
$posted = publicate($token, $user_id, $result[0]->id, $upload_result->hash);
$posted = json_decode($posted, true);
echo 'Картинка успешно загружена. Ее id:'.$posted['response']['post_id'];
if ($posted['error']) {
    echo 'Ошибка '.$posted['error'];
}

?>
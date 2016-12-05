<?php
use Intervention\Image\ImageManagerStatic as Image;

class Controller_Account extends Controller {

    public $uploaddir = PHOTO_PATH;

    function __construct()
    {
        $this->model  =  new Model_Account();
        $this->view = new View();

    }

    public function action_index()
    {
        session_start();

        if ($this->isLogin()) {
            if ($this->isPost()) {

                if ($_POST['quit']) {
                    $this->exitAccount();
                }

                if ($_POST['infosend']) {
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $age = htmlspecialchars(strip_tags($_POST['age']));
                    $info = htmlspecialchars(strip_tags($_POST['info']));
                    $_POST['ip'] = implode('',$this->model->get_data_info('ip'));

                    $file = $_FILES['userpic'];
                    if ($file['name']) {
                        $error = $this->loaadFile($file);
                        if ($error) {
                            $data_array = $this->model->get_data_info('photo');
                            $data['photo'] = $this->imageHtml($data_array['photo']);
                        } else {
                            $data['photo'] = $this->imageHtml($data['photo']);
                        }

                    } else {
                        $filedata = $this->model->get_data_info('photo');
                        $data['photo'] = $this->imageHtml($filedata['photo']);
                    }

                    $isValid = $this->isValid($_POST);
                    if ($isValid === true) {
                        if ($this->model->put_data_info($name, $age, $info)) {
                            $data['name'] = $name;
                            $data['age'] = $age;
                            $data['info'] = $info;
                        }
                    } else {
                        $validation_errors = $isValid;
                    }

                }

                if ($_POST['adminsend']) {
                    $data['list_error'] = $this->changeFileList();
                }

            }

        } else {
            $this->exitAccount();
        }

        $data = $this->model->get_data_info('ip','name', 'age', 'info', 'photo');
        $data['photo'] = $this->imageHtml($data['photo']);
        $data['error'] = $error;
        $data['photolist'] = $this->fileList();
        $data['validation_errors'] = $validation_errors;
        $this->view->generate('account.twig', $data);

    }

    private function loaadFile($file)
    {
        $img_ext = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            if ($file['error'] !== UPLOAD_ERR_OK) {
                return 'Ошибка! Не удалось загрузить файл! ' . $file['error'];
                exit;
            }
            $ext = pathinfo($file['name']);
            $filename = $file['name'];
            $filetype = $file['type'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $img_ext)) {
                return 'Файл, который вы пытаетесь загрузить, не является картинкой!';
            }


            $img_mime = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml');
            if (!in_array($filetype, $img_mime)) {
                return 'Файл, который вы пытаетесь загрузить, не является картинкой!';
            }

            $newfilename = time() . '-' . $filename;
            Image::make($file['tmp_name'])->resize(480, 480)->save("$this->uploaddir/$newfilename");

            //move_uploaded_file($file['tmp_name'], "$this->uploaddir/$newfilename");

            if ($this->model->put_data_file($newfilename)) {
                $data['photo'] = $newfilename;
                return $data;
            } else {
                $data['error'] = 'Ошибка соединения с базой';
                return $data;
            }
    }

    private function imageHtml($file_name)
    {
        if($file_name) {
            return $this->uploaddir . '/' . $file_name;
        }
        return '';
    }

    private function fileList()
    {
        $photos = scandir($this->uploaddir);
        $img_ext = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        $photolist = array();

        foreach ($photos as $photo) {
            if (!in_array($photo, array('.', '..'))) {
                $photoname = pathinfo($photo, PATHINFO_FILENAME);
                $photoext = pathinfo($photo, PATHINFO_EXTENSION);
                if (in_array($photoext, $img_ext)) {
                    $photo_src = $this->uploaddir . '/' . $photo;
                    $photolist[] = array('img' => $photo_src, 'photoname' => $photoname);
                }
            }
        }
        return $photolist;
    }

    private function changeFileList()
    {
        $photos = scandir($this->uploaddir);

        foreach ($photos as $photo) {
            if ($photo !== '.' && $photo !== '..') {
                $photoname = pathinfo($photo, PATHINFO_FILENAME);
                $photoext = pathinfo($photo, PATHINFO_EXTENSION);
                $newphotoname = strip_tags($_POST[$photoname]) . '.' . $photoext;
                $delete = $_POST[$photoname . '-del'];

                if ($delete) {
                    unlink("$this->uploaddir/$photo");
                    $newphotoname = NULL;
                } elseif ($newphotoname !== $photo) {
                    rename("$this->uploaddir/$photo", "$this->uploaddir/$newphotoname");
                }

                if ($this->model->change_photo_name($photo, $newphotoname)) {
                    $error = '';
                } else {
                    $error = 'Что-то пошло не так.';
                }
            }
        }
        return $error;
    }

    private function isValid($post)
    {
        $gump = new GUMP();

        $post = $gump->sanitize($post); // You don't have to sanitize, but it's safest to do so.

        $gump->validation_rules(array(
            'name'    => 'required|min_len,5',
            'info'    => 'required|min_len,50',
            'age'       => 'required|integer|min_numeric,10|max_numeric,100',
            'ip'      => 'required|valid_ip'
        ));

        $validated_data = $gump->run($_POST);

        if($validated_data === false) {
            return $gump->get_readable_errors();
        } else {
            return true;
        }
    }
}


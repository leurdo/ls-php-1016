<?php
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

                    $file = $_FILES['userpic'];
                    if ($file['name']) {
                        $data = $this->loaadFile($file);
                        if ($data['error']) {
                            $data_array = $this->model->get_data_info('photo');
                            $data['photo'] = $this->imageHtml($data_array['photo']);
                        } else {
                            $data['photo'] = $this->imageHtml($data['photo']);
                        }

                    } else {
                        $filedata = $this->model->get_data_info('photo');
                        $data['photo'] = $this->imageHtml($filedata['photo']);
                    }

                    if ($this->model->put_data_info($name, $age, $info)) {
                         $data['name'] = $name;
                         $data['age'] = $age;
                         $data['info'] = $info;
                    }
                }

                if ($_POST['adminsend']) {
                    $data['list_error'] = $this->changeFileList();
                }

            }

        } else {
            $this->exitAccount();
        }

        $data = $this->model->get_data_info('name', 'age', 'info', 'photo');
        $data['photo'] = $this->imageHtml($data['photo']);
        $data['photolist'] = $this->fileList();
        $this->view->generate('template_view.php','account_view.php', $data);
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
                $data['error'] = 'Файл, который вы пытаетесь загрузить, не является картинкой!';
                return $data;
                exit;
            }


            $img_mime = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml');
            if (!in_array($filetype, $img_mime)) {
                $data['error'] = 'Файл, который вы пытаетесь загрузить, не является картинкой!';
                return $data;
                exit;
            }

            $newfilename = time() . '-' . $filename;

            move_uploaded_file($file['tmp_name'], "$this->uploaddir/$newfilename");

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
            return '<p>Ваша фотография:' . $file_name . '</p><img src="' . $this->uploaddir . '/' . $file_name . '" height="100px">';
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
                    $photo_html = '<img src="' . $this->uploaddir . '/' . $photo . '" height="100px">';
                    $photolist[] = array('img' => $photo_html, 'photoname' => $photoname);
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
}
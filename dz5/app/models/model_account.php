<?php

class Model_Account extends Model {

    public function put_data_file($newfilename)
    {
        $sql = "UPDATE users SET photo = ? WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param('si', $newfilename, $_SESSION['id']);
            return $stmt->execute();
        }
        return false;
    }

    public function put_data_info($name, $age, $info)
    {
        $sql = "UPDATE users SET name = ?, age = ?, info = ? WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param('sisi', $name, $age, $info, $_SESSION['id']);
            return $stmt->execute();
        }
        return false;
    }

    public function get_data_info()
    {
        $stmt = $this->mysqli->prepare("SELECT * from users WHERE id = ?");
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();

        $result = $stmt->get_result();
        $record = $result->fetch_assoc();

        if ($record) {
            for ($i = 0; $i < func_num_args(); $i++) {
                $data[func_get_arg($i)] = $record[func_get_arg($i)];
            }
            return $data;
        }
        return false;
    }

    public function change_photo_name($oldname, $newname)
    {
        $sql = "UPDATE users SET photo = ? WHERE photo = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param('ss', $newname, $oldname);
            $stmt->execute();
            return true;
        }

        return false;
    }

}
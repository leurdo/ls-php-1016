<?php

class Model_Account extends Model {

    public function put_data_file($newfilename)
    {
        return User::where('id',$_SESSION['id'])->update(array('photo' => $newfilename));
    }

    public function put_data_info($name = '', $age = '', $info = '')
    {
        return User::where('id',$_SESSION['id'])->update(array('name' => $name, 'age' => $age, 'info' => $info));
    }

    public function get_data_info()
    {
        $record = User::where('id',$_SESSION['id'])->get()->toArray();

        $record = $record[0];

        if ($record) {
            for ($i = 0; $i < func_num_args(); $i++) {
                $column = func_get_arg($i);
                $data[$column] = $record[$column];
            }
            return $data;
        }
        return false;
    }

    public function change_photo_name($oldname, $newname)
    {
        return User::where('photo', $oldname)->update(['photo' => $newname]);
    }

}
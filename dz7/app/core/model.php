<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Model {

    public function __construct()
    {
        User::create_table();
    }
}
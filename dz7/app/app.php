<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      =>  DB_HOST,
    'database'  =>  DB_NAME,
    'username'  =>  DB_USER,
    'password'  =>  DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require_once 'user.php';
require_once 'core/model.php';
require_once 'core/controller.php';
require_once 'core/view.php';
require_once 'core/route.php';
Route::start();
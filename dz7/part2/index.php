<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require 'vendor/autoload.php';
require 'migrations.php';
require 'model.php';
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'dz7',
    'username' => 'root',
    'password' => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$migration_products = new Create_Products_Table;
$migration_products->up();
$migration_cats = new Create_Cats_Table;
$migration_cats->up();
$migration_rel = new Create_Cat_Product_Table;
$migration_rel->up();

$seeder = new DatabaseSeeder;
$seeder->run();




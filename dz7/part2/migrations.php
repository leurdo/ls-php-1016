<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create_Products_Table extends Migration
{
    public function up() {
        $schema = Capsule::schema();
        $schema->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 20);
            $table->text('description');
            $table->float('price');
            $table->timestamps();
        });
    }

    public function down() {
        Capsule::schema()->drop('products');
    }
}

class Create_Cats_Table extends Migration
{
    public function up() {
        $schema = Capsule::schema();
        $schema->create('cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cat', 20);
            $table->text('cat_description');
            $table->timestamps();
        });
    }

    public function down() {
        Capsule::schema()->drop('cats');
    }
}

class Create_Prod_Cat_Table extends Migration
{
    public function up() {
        $schema = Capsule::schema();
        $schema->create('prod_cat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer(product_id);
            $table->integer(cat_id);
            $table->integer(cat_order);
            $table->timestamps();
        });
    }

    public function down() {
        Capsule::schema()->drop('cats');
    }
}




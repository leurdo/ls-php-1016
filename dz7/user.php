<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name', 'age', 'info', 'photo'];
    public $timestamps = false;

    public function create_table()
    {
        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('ip');
                $table->string('username', 255);
                $table->string('password', 255);
                $table->string('name', 255)->nullable();
                $table->integer('age')->nullable();
                $table->text('info')->nullable();
                $table->string('photo', 255)->nullable();
            });
        }
    }


}
?>
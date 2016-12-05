<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price'];

    public function cats()
    {
        return $this->belongsToMany('Cat');
    }
}

class Cat  extends Model
{
    protected $fillable = ['cat', 'cat_description'];

    public function products()
    {
        return $this->belongsToMany('Product');
    }

}

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        require_once 'vendor/fzaninotto/faker/src/autoload.php';
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            Product::insert([
                'title' => $faker->text(20),
                'description' => $faker->text(50),
                'price' => $faker->randomNumber(2),
            ]);
        }
    }
}
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
class Cat_Product extends Model
{
    protected $table = 'cat_product';
    protected $fillable = ['product_id', 'cat_id', 'cat_order'];
}

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        require_once 'vendor/fzaninotto/faker/src/autoload.php';
        $faker = Faker::create();
        $product = new Product;
        $cat = new Cat;
        foreach (range(1,10) as $index) {
            $product->insert([
                'title' => $faker->text(20),
                'description' => $faker->text(50),
                'price' => $faker->randomNumber(2),
            ]);

            $cat->insert([
                'cat' => $faker->text(20),
                'cat_description' => $faker->text(50)
            ]);

            Cat_Product::insert([
                'cat_order' => $faker->randomDigitNotNull,
                'product_id' => rand(0,$product->count()),
                'cat_id' => rand(0,$cat->count()),
            ]);
        }
    }
}
<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find(1);
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals("1", $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals("2", $mostExpensiveProduct->id);
    }

    public function image() :MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $image = $product->image;
        self::assertNotNull($image);

        self::assertEquals("https://unsplash.com/photos/a-living-room-with-a-piano-and-chairs-m4MzJvXNxJ0", $image->url);
    }
}

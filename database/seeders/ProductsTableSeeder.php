<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::updateOrCreate([
            'title'         => 'title-1'
        ], [
            'slug'          => 'slug-1',
            'brief'         => 'brief-1',
            'description'   => 'description-1',
            'materials'     => 'materials-1',
            'colors'        => 'colors-1',
            'sizes'         => 'sizes-1',
            'price'         => 700.0
        ]);

    }
}

<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User([
            'name' => 'admin',
            'email' => 'admin@nscc.ca',
            'password' => '$2y$10$NEeLOakd42z6w6GlqrUQWedjTJdkFv82oKdQ3Ck.LCCOfqxaBOcnW',
            // `created_at` => '2020-04-13 02:22:06',
            // `updated_at` => '2020-04-13 02:22:06',
            // 'email_verified_at' => NULL,
            // 'remember_token' => NULL
        ]);

        $user->save();

        $category = new \App\Category([
            'name' => 'category 1'
        ]);

        $category->save(); //saves to DB

        $item = new \App\Item([
            'category_id' => '1',
            'title' => 'cat',
            'description' => 'meow',
            'price' =>1000,
            'quantity' => 5,
            'sku' => 001,
            'picture' => 'cat.png'
        ]);

        $item->save(); //saves to DB

        $item = new \App\Item([
            'category_id' => '1',
            'title' => 'truck',
            'description' => 'vroom',
            'price' =>30000,
            'quantity' => 5,
            'sku' => 002,
            'picture' => 'truck.jpg'
        ]);

        $item->save(); //saves to DB

    }
}
<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title'        =>  $faker->text('50'),
        'description'  =>  $faker->text('1000'),
        'image'        =>  'product.jpeg',
        'slug'         =>  $faker->slug(),
        'price'        =>  $faker->randomFloat(2, 0,1000),
        'quantity'     =>  $faker->numberBetween(10,100),
        'category'     =>  \App\Category::all()->first()->id,
    ];
});
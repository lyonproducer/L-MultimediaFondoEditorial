<?php

use Faker\Generator as Faker;

$factory->define(App\WorkDesign::class, function (Faker $faker) {
    $title = $faker->sentence(4);

    return [
        'user_id'=> rand(1,10),
        'category_id'=> rand(1,10),

        'title'=> $title,
        'excerpt'=> $faker->text(200),
        'description'=> $faker->text(100),
        'dependency'=> $faker->randomElement(['Interno','Externo']),
        'publishedDate'=> $faker->date($format = 'Y-m-d', $max = 'now'),
        'file'=> $faker->imageUrl($width = 1200, $height = 400),
        'status'=> $faker->randomElement(['Finalizado','En proceso']),
        'uploadBy'=> $faker->name,
    ];
});

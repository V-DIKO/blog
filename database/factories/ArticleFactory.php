<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(mt_rand(3, 10)),
        'describe'=>$faker->sentence(mt_rand(3,10)),
        'pic'=>$faker->imageUrl(),
        'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'publish_at' => $faker->dateTimeBetween('-1 month', '+3 days'),
    ];
});

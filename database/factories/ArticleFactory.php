<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Articles;
use Faker\Generator as Faker;

$factory->define(Articles::class, function (Faker $faker) {
    $images = ['about-bg.jpg', 'contact-bg.jpg', 'home-bg.jpg', 'post-bg.jpg'];
    $title = $faker->sentence(mt_rand(3, 10));

    return [
        'title' => $title,
        'subtitle' => str_limit($faker->sentence(mt_rand(10, 20)), 252),
        'page_image' => $images[mt_rand(0, 3)],
        'content_raw' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'publish_at' => $faker->dateTimeBetween('-1 month', '+3 days'),
        'meta_description' => "Meta for $title",
        'is_draft' => false,
    ];
});

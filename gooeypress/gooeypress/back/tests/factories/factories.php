<?php

$factory('Theme', [
    'title'              => $faker->sentence(),
    'notes'              => $faker->realText(2000),
    'price'              => rand(1, 98),
    'price_type'         => $faker->randomElement(['none', 'free', 'fixed', 'membership']),
    'link_purchase'      => $faker->url,
    'link_demo'          => $faker->url,
    'level'              => $faker->randomElement(['none', 'A', 'B', 'C', 'D']),
    'style_id'           => 'factory:Style',
    'genre_id'           => 'factory:Genre',
    'vendor_id'          => 'factory:Vendor',
    'author_id'          => 'factory:Author',
    'requirement_id'     => 'factory:Requirement',
    'default_layout_id'  => 'factory:Layout',
    'n_complete'         => 15,
    'screenshot'         => '',
    'hash'               => uniqid(),
    'responsive'         => $faker->randomElement(['yes', 'no']),
    'licence_id'         => 'factory:Licence',
    'platform_id'        => 'factory:Platform',
    'rating'             => 0,
    'rating_count'       => 0,
    'yslow'              => '',
    'likes_count'        => 0,
    'is_active_advert'   => $faker->randomElement(['yes', 'no']),
    'state'              => 'draft',
    'publication_status' => 'published',
]);

$factory('Style', [
    'name' => $faker->word,
]);
$factory('Genre', [
    'name' => $faker->word,
]);
$factory('Vendor', [
    'name' => $faker->word,
]);
$factory('Author', [
    'name' => $faker->word,
]);
$factory('Requirement', [
    'name' => $faker->word,
]);
$factory('Layout', [
    'name' => $faker->word,
]);
$factory('Licence', [
    'name' => $faker->word,
    'url'  => $faker->url,
]);
$factory('Platform', [
    'name' => $faker->word,
    'url'  => $faker->url,
]);

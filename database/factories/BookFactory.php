<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
      'title' => $faker->sentence,
      'summary' => $faker->paragraph,
      'price' => $faker->randomNumber(2),
      'author_id' => function() {
        return factory('App\Author')->create()->id;
      }
    ];
});

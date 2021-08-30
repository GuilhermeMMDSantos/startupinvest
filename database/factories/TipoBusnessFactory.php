<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TipoBusness;
use Faker\Generator as Faker;

$factory->define(TipoBusness::class, function (Faker $faker) {
    
    static $tiposBusness = array('B2B','B2C','B2B2C');
    static $contador = -1;
    $contador++;

    return [
        'nome' => $tiposBusness[$contador]
    ];
});

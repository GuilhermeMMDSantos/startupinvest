<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setores;
use Faker\Generator as Faker;

$factory->define(Setores::class, function (Faker $faker) {
    
    static $setores = array('Saúde','Educação','Imóveis','Mobilidade','Agricultura','Telecomunicações');
    static $contador = -1;
    $contador++;

    return [
        'nome'=>$setores[$contador]
    ];
});

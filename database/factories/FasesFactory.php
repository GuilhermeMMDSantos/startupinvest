<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fases;
use Faker\Generator as Faker;

$factory->define(Fases::class, function (Faker $faker) {
    
    static $fases = array('Projecto-Operação','Operação','Tração');
    static $contador = -1;
    $contador++;
    
    
    return [
        'nome'=>$fases[$contador]
    ];
});

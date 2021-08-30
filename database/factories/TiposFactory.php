<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tipos;
use Faker\Generator as Faker;

$factory->define(Tipos::class, function (Faker $faker) {
    
    
    static $tipos = array('Recurso','Evento','Forum');
    static $contador = -1;
    $contador++;

    return [
    'nome'=>$tipos[$contador]    
    ];
});

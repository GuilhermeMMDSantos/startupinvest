<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PotenciaisInvestidores;
use App\Startups;
use Faker\Generator as Faker;
use App\User;

$factory->define(PotenciaisInvestidores::class, function (Faker $faker) {
    
    static $idGerado = 5;
    $idGerado++;
    
    return [
        'id_user'=>$idGerado,
         'nome'=>$faker->sentence(1),
         'sobrenome'=>$faker->sentence(1),
         'video_porque_investir'=>'armazenamento/investidor/videos/video'.$idGerado.'.mp4'
    ];
});

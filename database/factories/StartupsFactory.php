<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Startups;
use App\PotenciaisInvestidores;
use Faker\Generator as Faker;

$factory->define(Startups::class, function (Faker $faker) {
    
    static $idGerado = 0;
    $idGerado++;

    return [
        'id_user'=> $idGerado,
        'nome'=>$faker->sentence(1),
        'setor_atividade'=>rand(1,6),
        'fase_desenvolvimento'=>rand(1,3),
        'tipobusness' => rand(1,3),
        'video_produto'=>'armazenamento/startups/videos/video1.mp4',
        'pitch_elevator'=>'A startup está construindo uma APLICAÇÃO WEB
         para ajudar OS EMPREENDEDORES COM STARTUP, INVESTIDORES,
        INCUBADORAS E ACELERADORAS a CONSEGUIREM ENCONTRAR-SE
         E ITERAGIR COM OBJECTIVO DE CRESCER com RAPIDEZ,A QUALQUER INSTANTE E DE FORMA SIMPLES',
         'img'=>'armazenamento/startups/img/img2.jpg'
      

    ];
});

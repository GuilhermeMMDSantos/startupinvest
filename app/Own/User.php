<?php

namespace App\Own;

use App\User as UserModell;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class User
{
    public static function updatePassword(UserModell $user, $senha)
    {
        $hashedSenha = Hash::make($senha);
        $user->update(
            ['password' => $hashedSenha]
        );
    }

    public static function gerarSenha($userId)
    {
        $ano = Carbon::now()->format('YYYY');
        $dia = Carbon::now()->format('dd');

        return $userId.'s'.$ano.'s'.$dia; 
    }
}

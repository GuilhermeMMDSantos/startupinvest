<?php

namespace App\Own;

use App\RodadasInvestimento;
use ErrorException;

class ClassRodadas
{


    public function verificarSeRodadaAberta($idStartup)
    {
        $rodadas = RodadasInvestimento::where('fk_startup', $idStartup)
            ->where('estado', 'aberta')
            ->get();
        if (count($rodadas) == 1)
            return true;
        return false;
    }

    public static function verificarSePodeInvestir($idStartup, $valorAInvestir)
    {
        $rodadas = RodadasInvestimento::where('fk_startup', $idStartup)
            ->where('estado', 'aberta')
            ->first();
 
        if (empty($rodadas))
            throw new ErrorException("Rodada Fechada");

        $tmp1 = $rodadas->valor_obtido + $valorAInvestir;
        $tmp2 = $rodadas->valor_objetivo - ($rodadas->valor_obtido + $valorAInvestir);

        if ($tmp1 > $rodadas->valor_objetivo)
            throw new ErrorException("Valor obtido + Valor a Investir ultrapassa o valor objetivo");

        if ($tmp2 != 0 && $tmp2 < $rodadas->valor_minimo_investimento)
            throw new ErrorException("A subtração entre o valor objetivo e (Valor obtido + Valor a Investir) deve ser maior o igual ao valor minimo a investir ou zero");

        if ($valorAInvestir < $rodadas->valor_minimo_investimento)
            throw new ErrorException("Valor a investir deve ser maior ou igual ao valor minimo a investir(".$rodadas->valor_minimo_investimento.")");

        return true;
    }
}

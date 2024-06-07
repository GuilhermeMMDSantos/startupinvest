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
            throw new ErrorException("Valor Obtido + Valor a Investir Ultrapassou o Valor Objetivo");

        if ($tmp2 != 0 && $tmp2 < $rodadas->valor_minimo_investimento)
            throw new ErrorException("A Subtração Entre o Valor Objetivo e (Valor Obtido + Valor a Investir) Deve Ser Maior Ou Igual Ao Valor Minimo a Investir Ou Zero");

        if ($valorAInvestir < $rodadas->valor_minimo_investimento)
            throw new ErrorException("Valor a Investir Deve Ser Maior ou Igual ao Valor Minimo a Investir(".$rodadas->valor_minimo_investimento.")");

        return true;
    }
}

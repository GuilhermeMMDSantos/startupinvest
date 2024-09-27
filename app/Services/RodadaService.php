<?php

namespace App\Services;

class RodadaService
{
    public function checkCloseRodadaStatus($rodada){
        if ($rodada->valor_objetivo != $rodada->valor_obtido)
            return (0);
        if ($rodada->estado != 'fechada')
            return (0);
        return (1);
    }
}
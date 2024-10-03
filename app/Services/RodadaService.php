<?php

namespace App\Services;

use App\RodadasInvestidores;

class RodadaService
{
    public function checkCloseRodadaStatus($rodada){
        if ($rodada->valor_objetivo != $rodada->valor_obtido)
            return (0);
        if ($rodada->estado != 'fechada')
            return (0);
        return (1);
    }

    public function updateRodadaStatus($rodada, $status)
    {
        $rodada->update([
            'estado' => $status
        ]);

        if ($status == 'sucedida'){
            RodadasInvestidores::where('fk_rodada', $rodada->id)->update([
                'status_investimento' => 3
            ]);
        }
        else if($status == 'anulada')
        {
            RodadasInvestidores::where('fk_rodada', $rodada->id)->update([
                'status_investimento' => 2
            ]);  
        }
    }
}
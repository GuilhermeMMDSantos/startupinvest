<?php

namespace App\Own\Traits;

use ErrorException;
use Illuminate\Http\Request;

trait UserTrait
{
    public function validarMetaPorcentagem($meta, $porcentagem)
    {
        try {
            $meta = $meta + 0.0;
            $porcentagem = $porcentagem  + 0.0;
            if ($porcentagem > 100)
                throw new ErrorException("Valor de porcentagem nao é aceitável (acima de 100%)");
            if ($meta > 9999999999.99)
                throw new ErrorException("Valor maximo aceitável para captação é 9.999.999.999,99");
            if ($meta == 0.0 || $porcentagem == 0.0)
                throw new ErrorException("Informe valores não nulos para meta e porcentagem.");
        } catch (ErrorException $e) {
            if ($e->getMessage() == 'A non well formed numeric value encountered')
                throw new ErrorException("Os valores de meta e porcentagem devem ser numéricos.");
            throw new ErrorException($e->getMessage());
        }
    }
}

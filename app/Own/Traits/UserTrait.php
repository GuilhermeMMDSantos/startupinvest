<?php

namespace App\Own\Traits;

use ErrorException;
use Illuminate\Http\Request;

trait UserTrait
{
    public function validarMetaPorcentagem($meta, $porcentagem)
    {
        $erros = null;
        $meta = $meta + 0.0;
        $porcentagem = $porcentagem  + 0.0;
        if ($porcentagem > 100)
            $erros["porcentagem"] = "Valor de porcentagem nao é aceitável (acima de 100%)";
        else if ($porcentagem == 0.0)
            $erros["porcentagem"] = "Valor da porcentagem não pode ser 0 (zero)";

        if ($meta > 9999999999.99)
            $erros["meta"] = "Valor maximo aceitável para captação é 9.999.999.999,99";
        else if($meta < 1000000)
            $erros["meta"] = "Valor da meta é menor que 1.000.000(um milhão)";
        else if ($meta == 0.0)
            $erros["meta"] = "Valor da meta não pode ser 0 (zero)";

        return $erros;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MachineLearningService;

class StartupGrowthController extends Controller
{
    protected $growthService;

    public function __construct(MachineLearningService $growthService)
    {
        $this->growthService = $growthService;
    }

    public function predict(Request $request)
    {
        // Valide os dados recebidos
       /* $validated = $request->validate([
            'features' => 'required|array', // Espera um array de atributos
        ]);

        // Enviar para o serviço de previsão*/
        $features = [47.78214378844623,42.514056842701486,4,0,1,1,3159227.216948688,22.26863155578769,9.344383899482153,8.08569822208289,26.313699014017104,29.711480685865304,54.87533506607744,19.240767191863483,23.040421359638813,4302.178285569554,677.7335410824883,9029.395256213485,16.319243715939344,7.819511530244093,139.8326340079292,62.19086140734478,18.816828130039394,0,0,1,1,1,32.55920014422431,31.64655199949887,2151213.4312767913,856005.48964403,0,0,1,75.30125558180872,3,7,1,3,5,2,2,2,4.409048620446297,49.998203324216206,89.01692192249317,6,1,44,2,5679336.461053522,0]; 
        $prediction = $this->growthService->predictGrowth($features);

        dd($prediction);
        /*return response()->json([
            'prediction' => $prediction,
        ]);*/
    }
}

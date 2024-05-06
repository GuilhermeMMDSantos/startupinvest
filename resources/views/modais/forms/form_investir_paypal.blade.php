
 <div class="row">
     <div class="col-12" style="padding-top:10px;">
         <label for="valor-a-investir">Montante a Investir(AOA)</label>
         <input type="number" class="form-control" name="valor_a_investir" id="valor-a-investir" style="height:61px !important;border-radius:5px;">
         <p><span class="badge badge-primary">valor mínimo:{{$rodada->valor_minimo_investimento}}AOA</span>&nbsp;<span class="badge badge-secondary">Valor máximo: {{$rodada->valor_objetivo - $rodada->valor_obtido}} AOA</span></p>
     </div>
 </div>

 <div class="row">
     <div class="col-12" style="padding-top:10px;">
         <label for="porcentagem-por-valor">Porcentagem pelo montante</label>
         <input type="number" class="form-control" name="porcentagem_por_valor" id="porcentagem-por-valor" value="2" style="height:61px !important;border-radius:5px;" disabled>
     </div>
 </div>


 <div>
     <div id="checkout-form">
         Containers for Card Fields hosted by PayPal
         <div id="card-name-field-container"></div>
         <div id="card-number-field-container"></div>
         <div id="card-expiry-field-container"></div>
         <div id="card-cvv-field-container"></div>

         <br><br>
         <button id="card-field-submit-button" type="button">
             Investir
         </button>
     </div>
 </div>

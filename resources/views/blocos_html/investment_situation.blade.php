@if($investidor->status_investimento == 0)
                                @if ($rodada->estado == 'fechada' && $presentUser==$rodada->fk_startup)
                                @if($investidor->contrato_mutou == NULL)
                                <p> Contracto de Investimento Pendente.</p>
                                <input type="file" class="field-contract-2" linker="{{$investidor->fk_investidor}}" accept=".pdf" name="contrato_investimento" id="load-contrato-investimento{{$investidor->fk_investidor}}" hidden>
                                <label type="button" class="btn btn-primary" for="load-contrato-investimento{{$investidor->fk_investidor}}" style="font-size:14px;border-radius:20px;margin-top:5px;">Adicionar Contrato</label>
                                @else
                                <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                    <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                                </div>
                                <a href="{{route('view_doc',[$rodada->id, $investidor->fk_investidor])}}" rule="button" class="btn btn-primary" style="font-size:12px;margin-top:5px;">Visualizar Contrato</a>

                                @if($investidor->status_contrato_investidor != 4)
                                <button class="btn btn-primary btn-eliminar-contrato" linker="{{$investidor->fk_investidor}}" style="font-size:12px;margin-top:5px;">Eliminar Contrato</button>
                                @endif

                                @if($investidor->status_contrato_investidor == 3)
                                <p>Investidor Discorda Com os Termos do Contrato.</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Abrir Meeting</button><br>

                                @elseif($investidor->status_contrato_investidor == 1)
                                <p>Assinatura do Investidor em Falta.</p>
                                @elseif($investidor->status_contrato_investidor == 4)
                                <p>Assinado Pelo Investidor</p>
                                @endif

                                @if($investidor->status_contrato_startup == 1)
                                <p>Assinatura do Sócio Fundador em Falta</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Assinar Contrato</button>
                                @elseif($investidor->status_contrato_startup == 4)
                                <p>Assinado Pelo Sócio Fundador</p>
                                @endif

                                @endif
                                @elseif($rodada->estado == 'aberta')
                                Investimento Captado.
                                @endif
                                @elseif($investidor->status_investimento == 1)
                                Investimento Reembolsado.
                                @elseif($investidor->status_investimento == 2)
                                Investimento Não Reembolsado
                                @endif
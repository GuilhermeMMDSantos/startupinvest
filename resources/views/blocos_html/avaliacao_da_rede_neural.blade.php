@if (!empty($rodada))
    <div class="col-sm-12">
        <div class="card shadow-lg mb-4 border-0">
            
            <div class="card-body">
                <h2 class="text-center font-weight-bold {{ $rodada->potencial_de_crescimento >= 50 ? 'text-success': ''}}" @if( $rodada->potencial_de_crescimento < 50) style="color:#dc3545d4;" @endif>
                    {{ $rodada->potencial_de_crescimento }}%
                </h2>

                <div class="mt-4 text-center">
                    @if ($rodada->potencial_de_crescimento >= 50)
                        <p class="text-success font-weight-bold">
                             Este negócio apresenta grande potencial de crescimento. Considere investir!
                        </p>
                    @else
                        <p class="font-weight-bold" style="color:#dc3545d4;">
                             Este negócio apresenta riscos consideráveis. Avalie cuidadosamente antes de investir.
                        </p>
                    @endif
                </div>

                <hr>
                <h5 class="font-weight-bold mt-4 text-center" style="color:#818182;">Pontos Fracos Identificados</h5>

                <div class="row mt-3">
                    @php
                        $weakPoints =  [
                            'Taxa_crescimento_mercado' =>
                                'Uma baixa taxa de crescimento do mercado indica que a startup pode ter dificuldades em expandir, pois está atuando em um setor que cresce lentamente.',
                            'Participacao_mercado_concorrentes' =>
                                'Se os concorrentes dominam a maior parte do mercado, pode ser difícil para a startup competir e ganhar clientes.',
                            'Numero_concorrentes_diretos' =>
                                'Muitos concorrentes diretos indicam alta competição, o que pode reduzir as chances de sucesso da startup.',
                            'Taxa_inflacao' =>
                                'Uma alta taxa de inflação pode aumentar os custos operacionais e diminuir o poder de compra dos clientes.',
                            'Taxas_juros' =>
                                'Juros altos dificultam o acesso a crédito, o que pode limitar os recursos financeiros da startup.',
                            'Taxa_desemprego' =>
                                'Um alto desemprego pode reduzir o número de clientes com poder de compra suficiente para adquirir os produtos ou serviços da startup.',
                            'Taxa_retencao_clientes' =>
                                'Uma baixa taxa de retenção de clientes indica insatisfação ou falta de fidelidade, prejudicando a receita recorrente.',
                            'Crescimento_base_clientes' =>
                                'Se a base de clientes não está crescendo, a startup terá dificuldades para aumentar suas vendas e escalar o negócio.',
                            'Ticket_medio' =>
                                'Um ticket médio baixo pode indicar que os clientes não estão dispostos a gastar muito, limitando a receita da startup.',
                            'LTV' =>
                                'Se o valor total gerado por um cliente ao longo do tempo é baixo, a startup pode não estar aproveitando seu potencial de receita.',
                            'CAC' =>
                                'Um custo alto para adquirir clientes pode indicar ineficiência na estratégia de marketing e vendas, prejudicando a lucratividade.',
                            'Tempo_medio_ciclo_vendas' =>
                                'Ciclos de vendas longos atrasam o fluxo de caixa, dificultando o crescimento da startup.',
                            'ROI' =>
                                'Um ROI negativo ou baixo significa que os investimentos feitos não estão trazendo os retornos esperados.',
                            'Despesas_operacionais_fixas' =>
                                'Custos fixos altos tornam a operação da startup menos flexível e aumentam o risco financeiro.',
                            'Margem_bruta' =>
                                'Uma margem bruta baixa indica que a startup está ganhando pouco em relação ao custo de produção.',
                            'Tamanho_equipe' =>
                                'Uma equipe muito pequena pode indicar falta de capacidade para lidar com todas as demandas da startup.',
                            'Media_experiencia' =>
                                'Se a média de experiência da equipe é baixa, a startup pode enfrentar dificuldades para lidar com os desafios do mercado.',
                            'Qtd_tecnico' =>
                                'Poucos especialistas na equipe podem indicar falta de competências essenciais para o sucesso do negócio.',
                            'Qtd_tecnico' =>
                                'Poucos especialistas na equipe podem indicar falta de competências essenciais para o sucesso do negócio.',
                            'Propriedade_intelectual' =>
                                'A falta de proteção da propriedade intelectual pode expor a startup a concorrência desleal ou cópia de ideias.',
                            'Tecnologia_exclusiva' =>
                                'Se a startup não possui tecnologias exclusivas, ela pode ser facilmente substituída por concorrentes.',
                            'Acesso_canais_distribuicao' =>
                                'Dificuldades em acessar canais de distribuição podem limitar a capacidade de alcançar clientes.',
                        ];

                        $unidades = [
                            'Taxa_crescimento_mercado' => '%',
                            'Participacao_mercado_concorrentes' => '%',
                            'Tamanho_mercado_alvo' => 'KZ',
                            'Taxa_inflacao' => '%',
                            'Taxas_juros' => '%',
                            'Taxa_desemprego' => '%',
                            'Taxa_retencao_clientes' => '%',
                            'Crescimento_base_clientes' => '%',
                            'Ticket_medio' => 'KZ',
                            'LTV' => 'KZ',
                            'CAC' => 'KZ',
                            'ROI' => '%',
                            'Despesas_operacionais_fixas' => 'KZ',
                            'Margem_bruta' => '%',
                           'Ciclo_vida_cliente' => '%',
                           'Taxa_adocao_inicial' => '%',
                       'Recorrencia_compra' => '%',
                           'Tempo_medio_ciclo_vendas' => 'dia(s)',
                           'Taxa_crescimento_receita' => '%',
                           'Duracao_media_ciclo_vendas' => 'dia(s)',
                           'Receita_Vendas'=> 'KZ',
                          'Margem_liquida'=> '%',
                          'Despesas_operacionais_variaveis'=> 'KZ',
                          'Grau_automacao'=> '%',
                         'Media_experiencia'=> 'ano(s)',
                         'Tempo_trabalho_juntos'=> 'ano(s)',
                         'Horas_trabalho_semana'=> 'H',
                         'Porcentagem_tempo_projeto'=> '%',
                         'Maior_valor_captado'=> 'KZ',
                        ];

                        $alias = [
                            'Receita_Assinatura',
                            'Receita_Publicidade',
                           'Receita_Outra',
                           'Mercado_B2C',
                           'Mercado_B2B',
                           'Mercado_B2B2C',
                           'Receita_Vendas',
                           'Receita_Assinatura',
                           'Receita_Publicidade',
                           'Receita_Outra'
                        ];
                    @endphp

                    @foreach ($atributosAvalicaoNegativa as $atributo)
                        @php 
                            $message = array_key_exists($atributo, $weakPoints) ? $weakPoints[$atributo] : 'Sem detalhes adicionais disponíveis.';
                        @endphp
                        @if(!in_array($atributo, $alias))
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <h6><strong>{{ $atributo }}:</strong> 
                                    @php $attrName = strtolower($atributo);  @endphp
                                    {{ $entradaModelo->$attrName }}
                                    @if (array_key_exists($atributo, $unidades))
                                        {{ $unidades[$atributo] }}
                                    @endif
                                </h6>
                                <p style="background-color:#e9ecef !important;border-radius:2px; padding:10px;">{{ $message }}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
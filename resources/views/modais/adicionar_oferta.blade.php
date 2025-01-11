<div class="modal fade" id="modal-adicionar-oferta" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"  style="height:500px !important;">
        <div class="modal-content"  style="height:100%; overflow-y: auto;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Criar Oferta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form-rodada-container">

                <div class="progress-container">
                    <div class="progress" style="height: 25px; background-color: #e9ecef; border-radius: 50px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: 0%; background-color: #007bff; transition: width 0.5s ease-in-out;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="progress-steps d-flex justify-content-between mt-2">
                        <span class="step-number">Folha 1</span>
                        <span class="step-number">Folha 2</span>
                        <span class="step-number">Folha 3</span>
                        <span class="step-number">Folha 4</span>
                        <span class="step-number">Folha 5</span>
                        <span class="step-number">Folha 6</span>
                        <span class="step-number">Folha 7</span>
                        <span class="step-number">Folha 8</span>
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data" id="form-criar-oferta">
                    @csrf

                    <div class="form-steps mt-4">
                        @include('blocos_html/formularios/add_oferta_info_mercado')
                        @include('blocos_html/formularios/add_oferta_info_indicadores_economicos')
                        @include('blocos_html/formularios/add_oferta_info_cliente')
                        @include('blocos_html/formularios/add_oferta_receita_dispesas')
                        @include('blocos_html/formularios/add_oferta_vantagem_competitiva')
                        @include('blocos_html/formularios/add_oferta_info_equipa')
                        @include('blocos_html/formularios/add_oferta_historico_investimento')
                        @include('blocos_html/formularios/add_oferta_dados_captacao')
                    </div>
                </form>

            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-publicar-oferta">
                    <span class="spinner-border spinner-border-sm" id="btn-spinner-oferta" role="status"
                        aria-hidden="true"></span>
                    <span>Publicar</span>
                </button>
            </div>-->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;

        const steps = document.querySelectorAll('.step');
        const progressBar = document.querySelector('.progress-bar');
        const progressSteps = document.querySelectorAll('.step-number');

        const showStep = (step) => {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index + 1 === step);
            });

            const progressPercentage = (step - 1) * 15;
            progressBar.style.width = `${progressPercentage}%`;
            progressBar.setAttribute('aria-valuenow', progressPercentage);

            progressSteps.forEach((el, index) => {
                el.classList.toggle('current', index + 1 === step);
            });
        };

        document.querySelectorAll('.next-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (currentStep < steps.length) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        document.querySelectorAll('.prev-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        $('[data-toggle="tooltip"]').tooltip();

        showStep(currentStep);
    });
</script>

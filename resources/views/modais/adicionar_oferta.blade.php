<div class="modal fade" id="modal-adicionar-oferta" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="height:500px !important;">
        <div class="modal-content" style="height:100%; overflow-y: auto;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Criar Oferta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-rodada-container">

                <div class="steps-container">
                    <div class="step-circle" id="step-1-circle">1</div>
                    <div class="step-circle" id="step-2-circle">2</div>
                    <div class="step-circle" id="step-3-circle">3</div>
                    <div class="step-circle" id="step-4-circle">4</div>
                    <div class="step-circle" id="step-5-circle">5</div>
                    <div class="step-circle" id="step-6-circle">6</div>
                    <div class="step-circle" id="step-7-circle">7</div>
                    <div class="step-circle" id="step-8-circle">8</div>
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
        </div>
    </div>
</div>

<script>
    const steps = document.querySelectorAll('.step');
    let currentStep = 1;

    const validateMaxDurationVideo = (file, maxDurationMin) => {
        return new Promise((resolve, reject) => {
            const video = document.createElement('video');
            video.preload = 'metadata';

            video.onloadedmetadata = function() {
                window.URL.revokeObjectURL(video.src);
                const durationInSeconds = video.duration;

                if (durationInSeconds / 60 > maxDurationMin) {
                    resolve(false);
                } else {
                    resolve(true);
                }
            };

            video.onerror = function() {
                reject('Não foi possível processar o vídeo.');
            };

            video.src = URL.createObjectURL(file);
        });
    };

    const validateFormPublicarRodada = async () => {
        const currentForm = steps[currentStep - 1];
        const inputs = currentForm.querySelectorAll('input[required], select[required]');
        let isValid = true;
        var checkboxesGroups4 = undefined;
        var checkboxesGroups5 = undefined;
        if (currentStep == 4)
            checkboxesGroups4 = currentForm.querySelectorAll('input[type="checkbox"][name="fontes_receita[]"]');
        if (currentStep == 5)
            checkboxesGroups5 = currentForm.querySelectorAll(
                'input[type="checkbox"][name="vantagem_competitiva[]"]');

        inputs.forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (currentStep == 8) {
            let pitchVideo = $("#input-pitch-video");
            try {
                if (!await validateMaxDurationVideo(pitchVideo[0].files[0], 15)) {
                    pitchVideo.addClass('is-invalid');
                    $("#input-pitch-video-alert").css({'color':'red'});
                    isValid = false;
                    console.log("Entrou 1");
                }else{
                    $("#input-pitch-video-alert").css({'color':'black'});
                    pitchVideo.removeClass('is-invalid');
                    console.log("Entrou 2");
                }
            } catch (error) {
                pitchVideo.addClass('is-invalid');
                $("#input-pitch-video-alert").css({'color':'red'});
                isValid = false;
                console.log("Entrou 3");
            }
        }
        console.log("COLOMBIANO: ");
        console.log(isValid);
        if (checkboxesGroups4 != undefined && checkboxesGroups4.length > 0) {
            const isCheckboxGroupChecked = Array.from(checkboxesGroups4).some(checkbox => checkbox.checked);
            if (!isCheckboxGroupChecked) {
                checkboxesGroups4.forEach(checkbox => checkbox.classList.add('is-invalid'));
                isValid = false;
            } else {
                checkboxesGroups4.forEach(checkbox => checkbox.classList.remove('is-invalid'));
            }
        }

        if (checkboxesGroups5 != undefined && checkboxesGroups5.length > 0) {
            const isCheckboxGroupChecked = Array.from(checkboxesGroups5).some(checkbox => checkbox.checked);
            if (!isCheckboxGroupChecked) {
                checkboxesGroups5.forEach(checkbox => checkbox.classList.add('is-invalid'));
                isValid = false;
            } else {
                checkboxesGroups5.forEach(checkbox => checkbox.classList.remove('is-invalid'));
            }
        }

        console.log("Valor de saida: ");
        console.log(isValid);
        return isValid;
    };

    document.addEventListener('DOMContentLoaded', function() {



        const stepCircles = document.querySelectorAll('.step-circle');

        const showStep = (step) => {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index + 1 === step);
            });


            stepCircles.forEach((el, index) => {
                el.classList.remove('current', 'completed');
                if (index + 1 < step) {
                    el.classList.add('completed');
                } else if (index + 1 === step) {
                    el.classList.add('current');
                }
            });
        };

        document.querySelectorAll('.next-step').forEach((btn) => {
            btn.addEventListener('click', async () => {
                if (await validateFormPublicarRodada()) {
                    if (currentStep < steps.length) {
                        currentStep++;
                        showStep(currentStep);
                    }
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

        showStep(currentStep);
    });
</script>

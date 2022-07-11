<form enctype="multipart/form-data" id="form-edit-intro-startup">
    @csrf
    <div style="width:120px;height:120px;border:1px solid #ccc;border-radius:50%;margin:auto;">
        <img id="img-startup-to-edit" src="{{asset('storage/'.$user->startup->logotipo)}}" accept=".jpg,.png" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
    </div>
    <input type="file" name="img_startup_edit" id="load_logotipo_edit_intro" hidden>
    <label for="load_logotipo_edit_intro" style="background-color:#cccccc78; display:inline-block;width:30px;height:30px;font-size:12px;border:thin;padding:5px;border-radius:50%;position:relative;top:-20px;left:57%;padding-left:10px;padding-top:7px;"><i class="fa fa-bell"></i></label>
    <div class="form-group">
        <label>Sector de actividade</label>
        <select class="form-control" name="setor_startup_edit">
            @foreach($setores as $setor)
            <option value="{{$setor->id}}" @if($setor->id == $user->startup->fk_setor_economico ) selected @endif>{{$setor->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Fase de Desenvolvimento</label>
        <select class="form-control" name="fase_startup_edit">
            @foreach($fases as $fase)
            <option value="{{$fase->id}}" @if($fase->id == $user->startup->fk_fase_desenvolvimento) selected @endif>{{$fase->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Tipo de Negócio</label>
        <select class="form-control" name="negocio_startup_edit">
            @foreach($tiposNegocio as $tipo)
            <option value="{{$tipo->id}}" @if($tipo->id == $user->startup->fk_tipo_negocio) selected @endif>{{$tipo->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        @php
        $userStartupCode = $user->code_user;
        $pitch = explode("##",$user->startup->pitch_elevator);
        $oQue = $pitch[3];
        $publico = $pitch[5];
        $ajudarNoQue = $pitch[7];
        $diferencial = $pitch[9];
        @endphp

        <label for="pitch_line1" class="">Pitch Elevator</label>
        <p>A startup, está desenvolvendo </p>
        <input type="text" id="pitch_line1" class="form-control" placeholder="qual é o produto/serviço? ex: software, serviço de..." name="pitch_line1" value="{{$oQue}}" autocomplete='off' maxlength="55" required>
        <p> para ajudar</p>
        <input type="text" class="form-control" placeholder="qual é publico alvo?" name="pitch_line2" value="{{$publico}}" autocomplete='off' maxlength="55" required>
        <p>a</p>
        <input type="text" class="form-control" placeholder="ajuda a fazer o quê?" name="pitch_line3" value="{{$ajudarNoQue}}" autocomplete='off' maxlength="55" required>
        <p> com </p>
        <input type="text" class="form-control" placeholder="o que torna a tua solução única?" name="pitch_line4" value="{{$diferencial}}" autocomplete='off' maxlength="55" required>

    </div>
    <div class="form-group">
        <input type='text' name='code_user' id="code-user" hidden>
    </div>
</form>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {


        $("#load_logotipo_edit_intro").change(function() {

            let myForm = new FormData();
            let csrf_code = '{{csrf_token()}}';
            let userCode = '{{$userStartupCode}}'
            let elementoInput = $("#load_logotipo_edit_intro").prop("files")[0];
            myForm.append('img_tmp', elementoInput);
            myForm.append('code', userCode)
            myForm.append('csrfmiddlewaretoken', csrf_code);

            $.ajax({
                url: '/load_tmp_img',
                type: 'POST',
                contentType: false,
                processData: false,
                data: myForm,
                success: function(response) {
                    let srcDaImg = $("#img-startup-to-edit").attr('src');
                    let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + '' + response;
                    $("#img-startup-to-edit").attr('src', novaSrc)
                },
                error: function(error) {
                    console.log("Erro");
                    console.log(error);
                }
            });
        });

        $("#btn-save-edit-intro-startup").click(function() {
            let code = '{{$userStartupCode}}';

            $("#code-user").val(code);
            let form = new FormData($("#form-edit-intro-startup")[0]);

            $.ajax({
                url: '/edit_intro_startup',
                type: 'POST',
                async:false,
                contentType: false,
                processData: false,
                data:form,
                success: function(response) {
                  
                    $('#modal-editar-introducao-startup').modal('hide');
                    atualizarIntroStartup();
                },
                error: function(error) {
                    console.log("ERRO");
                    console.log(error);
                }

            });


        });

        function atualizarIntroStartup() {


            var codigoStartup = "{{$userStartupCode}}";
            $.ajax({
                url: "/atualizar_introducao_startup",
                type: "get",
                data: {
                    '_token': '{{csrf_token()}}',
                    'codigoStartup': codigoStartup
                },
                success: function(response) {
                    $("#content-intro-startup").empty();
                    $("#content-intro-startup").html(response['returnHtm']);

                    console.log();

                    let srcDaImg = $("#myself_img").attr('src');
                    let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + '' + response['urlImg'];
                    $("#myself_img").attr('src', novaSrc)
                },
                error: function(erro) {
                    console.log("ERRO");
                    console.log(erro);
                }
            });
        }

    });
</script>
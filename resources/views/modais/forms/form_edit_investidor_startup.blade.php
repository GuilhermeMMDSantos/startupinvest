<form enctype="multipart/form-data" id="form-edit-edit-startup">
    @csrf
    <div class="form-group">
        <label>Nome</label>
        <input type="text" value="{{$investidorDaStartup->nome}}" id="nome-invest-edit" name="nome" class="form-control" placeholder="ex.: ecostartup; Dário" autocomplete="off">
    </div>
    <div class="form-group" id="form-group-sobrenome-edit" @if($investidorDaStartup->sobrenome == null) style="display:none;" @endif >
        <label>sobrenome</label>
        <input type="text" value="{{$investidorDaStartup->sobrenome}}" id="sobrenome-invest-edit" name="sobrenome" class="form-control" placeholder="ex.: Paulino">
    </div>
    <div class="form-group">
        <label>Tipo Entidade</label>
        <div>
            <label for="singular">Pessoa física</label> <input type="radio" value="2" name="tipo_investidor" class="tipo-investidor-edit" id="fisico-opt" @if($investidorDaStartup->tipo_entidade == 'Física') checked @endif>
            <label for="juridico">Pessoa Jurídica</label> <input type="radio" value="1" name="tipo_investidor" class="tipo-investidor-edit" id="juridico-opt" @if($investidorDaStartup->tipo_entidade == 'Jurídica') checked @endif >
        </div>
    </div>
    <div class="form-group">
        <label>Porcetagem</label>
        <input type="number" id="porcentagem-invest-edit" value="{{$investidorDaStartup->porcentagem_na_startup}}" name="porcentagem" class="form-control" placeholder="ex.: 23" min=0>
    </div>
    <div class="form-group">
        <label>Emai</label>
        <input type="email" id="email-invest-edit" name="email" value="{{$investidorDaStartup->email}}" class="form-control" placeholder="ecostartup@hotmail.com">
    </div>
    @php
    $codeInvest = $investidorDaStartup->id;
    @endphp
</form>

<script>
    $(function() {

        $(".tipo-investidor-edit").click(function() {
            if ($("#juridico-opt").prop('checked')) {
                $("#form-group-sobrenome-edit").hide(400);
                $("#sobrenome-invest-edit").val('');
            } else {
                $("#form-group-sobrenome-edit").show(400);
            }
        });

        $("#btn-save-edit-investidor-startup").click(function() {

            if ($("#nome-invest-edit").val().trim().length == 0 || $("#porcentagem-invest-edit").val().trim().length == 0 || $("#email-invest-edit").val().trim().length == 0)
                return false;

            let userCode = '{{$codeInvest}}';
            let formSerialize = $("#form-edit-edit-startup").serialize() + '&codeInvest=' + userCode;

            $.ajax({
                url: '/editar_investidor_startup',
                type: 'get',
                data: formSerialize,
                success: function(response) {
                   
                    $("#body-table-investidores-da-startup").append(response);
                    $("#modal-editar-investidor-startup").modal('hide');

                    $("#tupla_"+response['code']).empty();
                    $("#tupla_"+response['code']).append(response['html']);
                },
                error: function(error) {
                    console.log("ERRO AO EDITAR INVESTIDOR");
                    console.log(error);
                }
            });



        });


        




    });
</script>
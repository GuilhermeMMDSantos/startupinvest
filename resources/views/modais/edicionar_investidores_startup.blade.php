<div class="modal fade" id="modal-adicionar-investidores-startup" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Investidores Da Startup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-adicionar-investidores-startup-body">

                <form id="form-add-investidor">
                    @csrf
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" id="nome-invest-add" name="nome" class="form-control" placeholder="ex.: ecostartup; Dário" autocomplete="off">
                    </div>
                    <div class="form-group" style="display:none;" id="form-group-sobrenome">
                        <label>sobrenome</label>
                        <input type="text" id="sobrenome-invest-add" name="sobrenome" class="form-control" placeholder="ex.: Paulino">
                    </div>
                    <div class="form-group">
                        <label>Tipo Entidade</label>
                        <div>
                            <label for="singular">Pessoa física</label> <input type="radio" value="2" name="tipo_investidor" class="tipo-investidor" id="singular">
                            <label for="juridico">Pessoa Jurídica</label> <input type="radio" value="1" name="tipo_investidor" class="tipo-investidor" id="juridico" checked>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Porcetagem</label>
                        <input type="number" id="porcentagem-invest-add" name="porcentagem" class="form-control" placeholder="ex.: 23" min=0>
                    </div>
                    <div class="form-group">
                        <label>Emai</label>
                        <input type="email" id="email-invest-add" name="email" class="form-control" placeholder="ecostartup@hotmail.com">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save-edit-invest-startup">Salvar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(".tipo-investidor").click(function() {
            if ($("#juridico").prop('checked')) {
                $("#form-group-sobrenome").hide(400);
                $("#sobrenome-invest-add").val('');
            } else {
                $("#form-group-sobrenome").show(400);
            }
        });


        $("#btn-save-edit-invest-startup").click(function() {
            let userCode = '{{$codigoStartup}}';
            let formSerialize = $("#form-add-investidor").serialize() + '&codeUser=' + userCode;

            if ($("#nome-invest-add").val().trim().length == 0 || $("#porcentagem-invest-add").val().trim().length == 0 || $("#email-invest-add").val().trim().length == 0)
                return false;

            $.ajax({
                url: '/adicionar_investidor',
                type: 'get',
                data: formSerialize,
                success: function(response) {
                    $("#container-table-investor-of-startup").empty();
                    $("#container-table-investor-of-startup").append(response);
                    $("#modal-adicionar-investidores-startup").modal('hide');

                    
                },
                error: function(error) {
                    console.log("ERRO AO ADICIONAR INVESTIDOR");
                    console.log(error);
                }
            });

            
        });
    });
</script>
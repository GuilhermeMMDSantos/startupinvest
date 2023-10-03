@extends('../layout')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pagamentos.css')}}">
@endsection
@section('contentBody')
<div>

    @include('Admin/header_admin')

    <div class="container-fluid" style="padding-left: 6.5%;padding-right: 6.5%;">

        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Referência</th>
                            <th scope="col">Investidor</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Acção</th>
                        </tr>
                    </thead>
                    <tbody id="container-references">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(function() {

        loadPagamento();

        $("#container-references").on('click', '#btn-confirmar-pagamento', function() {

            var paymentId = $(this).attr('ref');

            $.aja({
                url: "/confirmar_pagamento",
                type: "get",
                data: {
                    'paymentId': paymentId
                },
                success: function(response) {
                    if (response['status'] == 200)
                        loadPagamento();
                },
                error: function(err) {
                    console.log("ERROR");
                    console.log(err);
                }
            });
        });

        function loadPagamento() {

            $.ajax({
                url: '/get_pagamentos',
                type: 'get',
                data: {},
                success: function(response) {
                    $("#container-references").append(response['html']);
                },
                error: function(err) {
                    console.log("Erro");
                    console.log(err);
                }
            });
        }
    });
</script>
@endsection
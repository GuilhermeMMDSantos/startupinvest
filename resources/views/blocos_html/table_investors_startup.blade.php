<table class="table table-striped">
    @if(count($investidoresDaStartup)>0)
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col" style="text-align:center;">Entidade</th>
            <th scope="col" style="text-align:center; ">Porcentagem</th>
            <th scope="col" style="text-align:center;">Contacto</th>

            @if($isMyProfile) <th scope="col" style="text-align:center;width:15%;"></th>@endif
        </tr>
    </thead>
    @endif
    <tbody id="body-table-investidores-da-startup">
        @forelse($investidoresDaStartup as $investors)
        <tr id="tupla_{{$investors->id}}">
            <td>{{$investors->nome}} @if($investors->sobrenome != null) {{$investors->sobrenome}} @endif</td>
            <td style="text-align:center;">{{$investors->tipo_entidade}}</td>
            <td style="text-align:center;">{{$investors->porcentagem_na_startup}}%</td>
            <td style="text-align:center;">{{$investors->email}}</td>

            @if($isMyProfile)
            <td style="text-align:center;">
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-editar-investidor-startup" data-code="{{$investors->id}}" style="height: 30px;font-size: 12px;">Editar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-editar" style="height: 30px;font-size: 12px;" data-toggle="modal" data-target="#modal-excluir-investidor-startup" data-code="{{$investors->id}}">Eliminar</button>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="4" style="color:#3333339c;">Startup sem investidor informado</td>
        </tr>
        @endforelse
    </tbody>
</table>
<div id="pagination">
    {{ $investidoresDaStartup->links() }}
</div>
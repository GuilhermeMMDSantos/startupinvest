@if(count($investidoresDaStartup)>0)
<table class="table">

    <thead>
        <tr class="no-mobile-table">
            <th scope="col">Nome</th>
            <th scope="col" style="text-align:center;">Entidade</th>
            <th scope="col" style="text-align:center; ">Porcentagem</th>
            <th scope="col" style="text-align:center;">Contacto</th>

            @if($isMyProfile) <th scope="col" style="text-align:center;width:15%;"></th>@endif
        </tr>
        
    </thead>

    <tbody id="body-table-investidores-da-startup">
        @foreach($investidoresDaStartup as $investors)
        <tr id="tupla_{{$investors->id}}" class="no-mobile-table">
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
        <tr class="mobile-table">
            <td>
                {{$investors->nome}} @if($investors->sobrenome != null) {{$investors->sobrenome}} @endif,
                entidade {{$investors->tipo_entidade}} com
                {{$investors->porcentagem_na_startup}}%<br>
                {{$investors->email}}
            </td>
            @if($isMyProfile)
            <td style="text-align:center;">
                <button type="button" class="btn btn-primary btn-editar mb-2" data-toggle="modal" data-target="#modal-editar-investidor-startup" data-code="{{$investors->id}}" style="height: 30px;font-size: 12px;display:block;">Editar</button>
                
                <button type="button" class="btn btn-primary btn-editar" style="height: 30px;font-size: 12px;" data-toggle="modal" data-target="#modal-excluir-investidor-startup" data-code="{{$investors->id}}">Eliminar</button>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<div id="pagination">
    {{ $investidoresDaStartup->links() }}
</div>

@else
<div class="card mb-5" style="border:none;">
    <div class="card-body">
        <div style="width:60px;height:60px;margin:auto;">
            <img src="{{asset('assets/img/formacao1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
        </div>

        <p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Startup sem investidor informado</p>
    </div>
</div>
@endif
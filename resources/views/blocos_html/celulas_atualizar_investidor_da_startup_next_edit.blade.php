<td>{{$investidorDaStartup->nome}} @if($investidorDaStartup->sobrenome != null) {{$investidorDaStartup->sobrenome}} @endif</td>
    <td style="text-align:center;"> {{$tipoEntidadeToTupla}}</td>
    <td style="text-align:center;"> {{$investidorDaStartup->porcentagem_na_startup}}</td>
    <td style="text-align:center;">{{$investidorDaStartup->email}}</td>
    <td style="text-align:center;">
        <button type="button" class="btn btn-primary btn-editar" style="height: 30px;font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal-editar-investidor-startup" data-code="{{$investidorDaStartup->id}}">Editar</button>
        &nbsp;
        <button type="button" class="btn btn-primary btn-editar" style="height: 30px;font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal-excluir-investidor-startup" data-code="{{$investidorDaStartup->id}}">Eliminar</button>
    </td>
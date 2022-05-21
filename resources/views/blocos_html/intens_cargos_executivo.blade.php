@foreach($cargosExecutivo as $cargo)
<option value="{{$cargo->id}}">{{$cargo->descricao}}({{$cargo->sigla}})</option>
@endforeach
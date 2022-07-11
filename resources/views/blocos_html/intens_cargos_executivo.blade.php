<label class="label_emp">Cargos Executivos</label><br>
@foreach($cargosExecutivo as $cargo)

@php
$wasAdd = in_array($cargo->id,$idCargosJaAtribuidos);
@endphp

<div class="form-check form-check-inline">
    <input class="form-check-input item-cargos-executivo" type="checkbox" id="cargo{{$cargo->id}}" name="busnessType" value="{{$cargo->id}}" @if($wasAdd) disabled @endif>
    <label class="form-check-label" for="cargo{{$cargo->id}}">{{$cargo->descricao}}({{$cargo->sigla}})</label>
</div>

@endforeach
@if ($entry->created_at == $entry->updated_at)
<a href="{{ backpack_url('entradasalida/'.$entry->getKey() . '/registrar-salida') }}" class="btn btn-sm btn-warning" onclick="return confirm('¿Estás seguro de que deseas registrar la salida de este vehículo?')">Registrar Salida</a>
@else
<label class="badge badge-warning">Salida emitida</label>
@endif
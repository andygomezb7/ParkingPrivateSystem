@if ($entry->type == 1 || $entry->type == 2) 
<a href="{{ backpack_url('vehiculos/'.$entry->getKey() . '/comienza-mes') }}" class="btn btn-sm btn-warning" onclick="return confirm('¿Estas seguro que quieres comenzar un mes nuevo?')">Comienza mes</a>
@endif

@if ($entry->type == 1)
<!-- <a href="{{ backpack_url('vehiculos/'.$entry->getKey() . '/pago-residentes') }}" class="btn btn-sm btn-warning" onclick="return confirm('¿Estas seguro que quieres Generar el pago de este residente {{ $entry->placa }}?')">Pago de residentes</a> -->
@endif
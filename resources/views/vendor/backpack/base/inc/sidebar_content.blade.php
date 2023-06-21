{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('vehiculos') }}"><i class="nav-icon la la-question"></i> Vehiculos</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('entradasalida') }}"><i class="nav-icon la la-question"></i> Entradasalidas</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('tipos-vehiculo') }}"><i class="nav-icon la la-question"></i> Tipos vehiculos</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('informe') }}"><i class="nav-icon la la-question"></i> Informe</a></li>
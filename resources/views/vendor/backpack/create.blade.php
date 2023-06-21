@extends('backpack::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('informe.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre_documento">Nombre del documento</label>
                            <input type="text" name="nombre_documento" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Informe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
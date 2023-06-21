<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntradaSalida;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InformeExport;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class InformeController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    public function setup()
    {
        $this->crud->setModel(EntradaSalida::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/informe');
        $this->crud->setEntityNameStrings('Informe', 'Informes');
        $this->crud->setListView('vendor.backpack.create');
    }

    public function create()
    {
        return view('backpack.informe.create');
    }

    public function store(Request $request)
    {
        $nombreDocumento = $request->input('nombre_documento');

        // Obtener los registros de EntradaSalida
        $registros = EntradaSalida::all();

        // Generar el archivo Excel
        return Excel::download(new InformeExport($registros), $nombreDocumento . '.xlsx');
    }
}
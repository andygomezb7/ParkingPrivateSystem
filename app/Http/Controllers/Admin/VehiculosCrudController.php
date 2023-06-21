<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VehiculosRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Vehiculos;
use App\Models\Entradasalida;
use App\Models\TiposVehiculo;
use Illuminate\Support\Facades\View;

/**
 * Class VehiculosCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VehiculosCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Vehiculos::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vehiculos');
        CRUD::setEntityNameStrings('vehiculos', 'vehiculos');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
   public function setupListOperation()
    {
        // ...

        $this->crud->addColumn([
            'name' => 'type',
            'label' => 'Type',
            'value' => function($entry) {
                $tipo = ($entry->type == 1 ? 'Residente' : ($entry->type == 2 ? 'Oficial' : 'No residente'));
                return $tipo;
            }
        ]);

        $this->crud->addColumn([
            'name' => 'placa',
            'label' => 'Placa',
            'value' => function ($entry) {
                return strtoupper($entry->placa);
            }
        ]);

        $this->crud->addColumn([
            'name' => 'marca',
            'label' => 'Marca',
        ]);

        $this->crud->addColumn([
            'name' => 'modelo_linea',
            'label' => 'Modelo/Linea',
        ]);

        $this->crud->addColumn([
            'name' => 'hora_entrada',
            'label' => 'Ultima entrada',
        ]);

        $this->crud->addColumn([
            'name' => 'hora_salida',
            'label' => 'Ultima salida',
        ]);

        $this->crud->addButtonFromView('line', 'cerrar_mes', 'cerrar_mes', 'end');

        // ...
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    public function setupCreateOperation()
    {
        // ...

        $this->crud->addField([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => TiposVehiculo::pluck('name', 'id')->toArray(),
        ]);

        $this->crud->addField([
            'name' => 'placa',
            'label' => 'Placa',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'marca',
            'label' => 'Marca',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'modelo_linea',
            'label' => 'Modelo/Linea',
            'type' => 'text',
        ]);

        // ...
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Comienza mes
     * 
     * @return view
     */
    public function comienzaMes($id)
    {
        $vehiculo = Vehiculos::find($id);

        if ($vehiculo) {
            // La placa existe en la base de datos de vehiculos
            if ($vehiculo->type == 2) {
                // Es un vehículo oficial, vaciar los registros de entrada/salida
                EntradaSalida::where('placa', $vehiculo->placa)->delete();
                $vehiculo->hora_entrada = null;
                $vehiculo->hora_salida = null;
                $vehiculo->save();

                $mensaje = "Registros de parqueo eliminados satisfactoriamente para el vehículo oficial.";
            } elseif ($vehiculo->type == 1) {
                // Es un vehículo residente, reiniciar el campo horasacumuladas
                $vehiculo->hora_entrada = null;
                $vehiculo->hora_salida = null;
                $vehiculo->horasacumuladas = '0';
                $vehiculo->save();

                $mensaje = "Tiempo en parqueo reiniciado satisfactoriamente para el vehículo residente.";
            } else {
                // El tipo de vehículo no es válido
                $mensaje = "El tipo de vehículo no es válido.";
            }
        } else {
            // La placa no existe en la base de datos de vehiculos
            $mensaje = "La placa no existe en la base de datos de vehiculos.";
        }

        return redirect()->back()->with('message', $mensaje);
        // return view('backpack.crud.comienza_mes', compact('mensaje'));
    }
}

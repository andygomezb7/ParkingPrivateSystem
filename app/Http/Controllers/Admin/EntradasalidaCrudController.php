<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EntradasalidaRequest;
// use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\CrudController as BaseCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Vehiculos;
use App\Models\Entradasalida;
use Carbon\Carbon;
use App\Http\Controllers\Admin\Model;

/**
 * Class EntradasalidaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EntradasalidaCrudController extends BaseCrudController
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
        CRUD::setModel(\App\Models\Entradasalida::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/entradasalida');
        CRUD::setEntityNameStrings('entradasalida', 'Entradas');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */

        $this->crud->addColumn([
            'name' => 'tipo_vehiculo',
            'label' => 'Tipo',
            'type' => 'text',
            'value' => function ($entry) {
                $tipo = $vehiculo = Vehiculos::where('placa', $entry->placa)->first();
                if ($tipo) {
                    $type = ($tipo->type == 1 ? 'Residente' : ($tipo->type == 2 ? 'Oficial' : 'No residente'));
                } else {
                    $type = 'No residente';
                }
                return $type;
            },
        ]);

        // Columnas a mostrar en la lista
        $this->crud->addColumn([
            'name' => 'placa',
            'label' => 'Placa',
            'type' => 'text',
            'view' => 'backpack.custom.actions',
            'value' => function ($entry) {
                return strtoupper($entry->placa);
            }
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Entrada',
            'type' => 'datetime',
        ]);

        $this->crud->addColumn([
            'name' => 'updated_at',
            'label' => 'Salida',
            'type' => 'text',
            'value' => function ($entry) {
                if ($entry->updated_at == $entry->created_at) {
                    return 'Estacionado';
                } else {
                    return $entry->updated_at;
                }
            },
        ]);

        $this->crud->addColumn([
            'name' => 'time_difference',
            'label' => 'Minutos',
            'type' => 'text',
            'value' => function ($entry) {
                $createdAt = \Carbon\Carbon::parse($entry->created_at);
                $updatedAt = \Carbon\Carbon::parse($entry->updated_at);
                $differenceInMinutes = $updatedAt->diffInMinutes($createdAt);

                return $differenceInMinutes . 'Min';
            },
        ]);

        $this->crud->addColumn([
            'name' => 'saldo_cuota',
            'label' => 'Saldo',
            'type' => 'text',
            'value' => function ($entry) {
                $tipo = $vehiculo = Vehiculos::where('placa', $entry->placa)->first();;
                $createdAt = \Carbon\Carbon::parse($entry->created_at);
                $updatedAt = \Carbon\Carbon::parse($entry->updated_at);
                $differenceInMinutes = $updatedAt->diffInMinutes($createdAt);
                $cuota = ($tipo) ? $differenceInMinutes*0.05 : $differenceInMinutes*0.5;

                if ($tipo) {
                    if ($tipo->type == 1) { // Residente
                        return  '$' . number_format($cuota,2);
                    } else if ($tipo->type == 2) { // Oficial
                        return '-';
                    }
                } else {
                    return  '$' . number_format($cuota,2);
                }
            },
        ]);

        $this->crud->addButtonFromView('line', 'registrar_salida', 'registrar_salida', 'end');


        // Deshabilitar los botones de editar y borrar
        $this->crud->removeButton('update');
        // $this->crud->removeButton('delete');

        // Agregar botón de "Registrar Salida"
        // $this->crud->addButtonFromView('line', 'registrar_salida', 'registrar_salida', 'end', ['id' => '{{ $entry->getKey() }}']);

        // ...
        
        // Configuración de las relaciones y filtros de la lista
        // $this->crud->addFilter([
        //     'name' => 'tipo',
        //     'type' => 'dropdown',
        //     'label' => 'Tipo',
        //     'options' => [
        //         '1' => 'Residente',
        //         '2' => 'Oficial',
        //         // Agregar aquí otras opciones según tus necesidades
        //     ],
        // ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EntradasalidaRequest::class);

        // Campos para el formulario de creación
        $this->crud->addField([
            'name' => 'placa',
            'label' => 'Placa',
            'type' => 'text',
        ]);

        // Agregar aquí otros campos adicionales según tus necesidades
        
        // Configuración de las reglas de validación
        // $this->crud->setValidationRules([
        //     'placa' => 'required',
        //     // Agregar aquí otras reglas de validación según tus necesidades
        // ]);
        $this->save();

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

    protected function save()
    {
        // $placa = $request->input('placa');

        // $data = $this->request->all();
        // $placa = $data['placa'];
        $placa = $this->crud->getRequest()->input('placa');
        $vehiculo = Vehiculos::where('placa', $placa)->first();

        if (!$vehiculo) {
            // El vehículo con la placa proporcionada no existe en la tabla "vehiculos"
            // Realizar las acciones necesarias para vehículos no registrados
            // Ejemplo:
            return redirect()->back()->withErrors(['message' => 'Puedes ingresar una placa existente o inexistente']);
        }

        $vehiculo->hora_entrada = now();
        $vehiculo->save();

        // Realizar acciones según el tipo de vehículo
        if ($vehiculo->tipo === 'Oficial') {
            // Asociar la estancia (hora de entrada y hora de salida) con el vehículo oficial
            // Realizar las acciones necesarias para vehículos oficiales
        } elseif ($vehiculo->tipo === 'Residente') {
            // Sumar la duración de la estancia al tiempo total acumulado
            // Realizar las acciones necesarias para vehículos residentes
        } else {
            // Obtener el importe a pagar para vehículos no residentes
            // Realizar las acciones necesarias para vehículos no residentes
        }

        // Redireccionar a la vista de lista después de guardar el registro
        return redirect(backpack_url('entradasalida'))->with('success', 'Registro guardado exitosamente');
    }

    /**
     * Update the entity, then execute the update action.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($placa, $id)
    {
        
        $entradaSalida = Entradasalida::find($id);
        $entradaSalida->updated_at = now();
        $entradaSalida->save();

        $diffInMinutes = $entradaSalida->created_at->diffInMinutes($entradaSalida->updated_at);

        $vehiculo = Vehiculos::where('placa', $placa)->firstOrFail();
        $vehiculo->hora_salida = now();
        $vehiculo->horasacumuladas += $diffInMinutes;
        $vehiculo->save();

        // return view('modal', compact('diffInMinutes'));
        // Realizar acciones según el tipo de vehículo
        if ($vehiculo->tipo === 'Oficial') {
            // Realizar acciones necesarias al registrar la salida de vehículos oficiales
        } elseif ($vehiculo->tipo === 'Residente') {
            // Realizar acciones necesarias al registrar la salida de vehículos residentes
        } else {
            // Realizar acciones necesarias al registrar la salida de vehículos no residentes
        }

    }

    /**
     * Registra salida.
     * 
     * @return redirect
     */

    public function registrarSalida($id)
    {
        // $request = new EntradasalidaRequest();
        $placa = Entradasalida::where('id', $id)->select('placa')->first();
        $this->update($placa->placa, $id);

        return redirect()->back()->with('message', 'La salida del vehículo ha sido registrada con éxito.');
    }
}

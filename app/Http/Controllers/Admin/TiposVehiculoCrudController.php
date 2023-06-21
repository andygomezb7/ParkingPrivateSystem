<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TiposVehiculoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TiposVehiculoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TiposVehiculoCrudController extends CrudController
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
        CRUD::setModel(\App\Models\TiposVehiculo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tipos-vehiculo');
        CRUD::setEntityNameStrings('tipos vehiculo', 'tipos vehiculos');
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
            'name' => 'name',
            'label' => 'Nombre',
        ]);

        $this->crud->addColumn([
            'name' => 'costo',
            'label' => 'Costo por minuto',
        ]);

        $this->crud->addColumn([
            'name' => 'cobro',
            'label' => 'Se cobra mensual?',
            'value' => function($entry) {
                $tipo = ($entry->cobro == 0 ? 'No' : ($entry->cobro == 1 ? 'Si' : 'No identificado'));
                return $tipo;
            }
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TiposVehiculoRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Nombre',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'costo',
            'label' => 'Costo',
            'type' => 'text',
            'placeholder' => '0.5'
        ]);

        $this->crud->addField([
            'name' => 'cobro',
            'label' => 'Se cobrara mensual?',
            'type' => 'select_from_array',
            'options' => [1 => 'Si', 0 => 'No'],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
}

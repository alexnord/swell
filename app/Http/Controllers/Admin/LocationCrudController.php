<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\LocationRequest as StoreRequest;
use App\Http\Requests\LocationRequest as UpdateRequest;

/**
 * Class LocationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class LocationCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Location');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/location');
        $this->crud->setEntityNameStrings('location', 'locations');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'active', 'type' => 'boolean', 'label' => 'Active']);
        $this->crud->addColumn(['name' => 'title', 'type' => 'text', 'label' => 'Name']);
        $this->crud->addColumn([
            'type' => 'select',
            'label' => 'NOAA Station', // Table column heading
            'name' => 'noaa_station_id', // the column that contains the ID of that connected entity;
            'entity' => 'station', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => 'App\Models\NoaaStation', // foreign key model
        ]);
        $this->crud->addColumn([
            'type' => 'select',
            'label' => 'Buoy', // Table column heading
            'name' => 'buoy_id', // the column that contains the ID of that connected entity;
            'entity' => 'buoy', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => 'App\Models\Buoy', // foreign key model
        ]);

        // Fields
        $this->crud->addField(['name' => 'active', 'type' => 'checkbox', 'label' => 'Active']);
        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Name']);
        $this->crud->addField(['name' => 'lat', 'type' => 'number', 'label' => 'Latitude', 'attributes' => ["step" => "any"]]);
        $this->crud->addField(['name' => 'lng', 'type' => 'number', 'label' => 'Longitude', 'attributes' 
            => ["step" => "any"]]);
        $this->crud->addField([  
            'label' => 'NOAA Station',
            'type' => 'select',
            'name' => 'noaa_station_id', // the db column for the foreign key
            'entity' => 'station', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => 'App\Models\NoaaStation',
            // optional
            'options' => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        $this->crud->addField([  
            'label' => 'Buoy',
            'type' => 'select',
            'name' => 'buoy_id', // the db column for the foreign key
            'entity' => 'buoy', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => 'App\Models\Buoy',
            // optional
            'options' => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        // add asterisk for fields that are required in LocationRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

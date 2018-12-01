<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\NoaaStationRequest as StoreRequest;
use App\Http\Requests\NoaaStationRequest as UpdateRequest;

/**
 * Class NoaaStationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NoaaStationCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\NoaaStation');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/noaaStation');
        $this->crud->setEntityNameStrings('NOAA Station', 'NOAA Stations');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'active', 'type' => 'boolean', 'label' => 'Active']);
        $this->crud->addColumn(['name' => 'noaa_id', 'type' => 'text', 'label' => 'NOAA Station ID']);
        $this->crud->addColumn(['name' => 'title', 'type' => 'text', 'label' => 'Name']);
        $this->crud->addColumn(['name' => 'lat', 'type' => 'text', 'label' => 'Latitude']);
        $this->crud->addColumn(['name' => 'lng', 'type' => 'text', 'label' => 'Longitude']);

        // Fields
        $this->crud->addField(['name' => 'active', 'type' => 'checkbox', 'label' => 'Active']);
        $this->crud->addField(['name' => 'noaa_id', 'type' => 'text', 'label' => 'NOAA Station ID']);
        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Name']);
        $this->crud->addField(['name' => 'lat', 'type' => 'number', 'label' => 'Latitude', 'attributes' => ["step" => "any"]]);
        $this->crud->addField(['name' => 'lng', 'type' => 'number', 'label' => 'Longitude', 'attributes' 
            => ["step" => "any"]]);
        $this->crud->addField([
            'name' => 'timezone',
            'type' => 'text',
            'label' => 'Timezone',
            'hint'  => 'PHP valid tiemzone. <a href="http://php.net/manual/en/timezones.php" target="_blank">More Info</a>',
            'attributes' => [
                'placeholder' => 'America/Los_Angeles',
            ],
                
        ]);

        // add asterisk for fields that are required in NoaaStationRequest
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

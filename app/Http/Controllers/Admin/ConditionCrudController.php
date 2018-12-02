<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ConditionRequest as StoreRequest;
use App\Http\Requests\ConditionRequest as UpdateRequest;

/**
 * Class ConditionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ConditionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Condition');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/condition');
        $this->crud->setEntityNameStrings('condition', 'conditions');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'active', 'type' => 'boolean', 'label' => 'Active']);
        $this->crud->addColumn(['name' => 'title', 'type' => 'text', 'label' => 'Name']);

        // Fields
        $this->crud->addField(['name' => 'active', 'type' => 'checkbox', 'label' => 'Active']);
        $this->crud->addField(['name' => 'title', 'type' => 'text', 'label' => 'Name']);

        // add asterisk for fields that are required in ConditionRequest
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

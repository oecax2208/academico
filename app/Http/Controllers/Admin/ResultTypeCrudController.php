<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ResultTypeRequest as StoreRequest;
use App\Http\Requests\ResultTypeRequest as UpdateRequest;

/**
 * Class ResultTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ResultTypeCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(['role:admin']);
    }
    
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ResultType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/resulttype');
        $this->crud->setEntityNameStrings('resulttype', 'result_types');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in ResultTypeRequest
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

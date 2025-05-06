<?php

namespace MedianetDev\BackpackForm\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use MedianetDev\BackpackForm\Http\Requests\FormbuilderEntryRequest;

/**
 * Class FormbuilderentryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FormbuilderEntryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\MedianetDev\BackpackForm\Models\FormbuilderEntry::class);
        CRUD::setEntityNameStrings(__('medianet-dev.backpack-form::formbuilder.labels.entity_entry'), __('medianet-dev.backpack-form::formbuilder.labels.entities_entry'));
        $id_form = Route::current()->parameter('id_form');
        if ($id_form) {
            $this->crud->addClause('where', 'fb_form_id', '=', $id_form);
            CRUD::setRoute(config('backpack.base.route_prefix') . '/formbuilder/' . $id_form . '/formbuilderentry');
        } else {
            CRUD::setRoute(config('backpack.base.route_prefix') . '/formbuilderentry');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'formbuilder.title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.entity_form')),
                'type' => 'text'
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.created_at'))
            ]
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'formbuilder.title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.entity_form')),
                'type' => 'text'
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.created_at'))
            ],
            [
                'name' => 'structure_result',
                'type' => 'view',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.form')),
                'view' => 'medianet.backpack-form::columns.form_builder_entry',
            ]
        ]);
        $this->crud->removeColumn('structure_form');
        $this->crud->removeColumn('fb_form_id');
    }
}

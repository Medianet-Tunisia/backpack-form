<?php

namespace MedianetDev\BackpackForm\Http\Controllers\Admin;

use App\Traits\CrudPermissions;
use App\Traits\Field;
use Backpack\CRUD\app\Library\Widget;
use MedianetDev\BackpackForm\Models\Formbuilder;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use MedianetDev\BackpackForm\Http\Requests\FormbuilderRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\App;
use MedianetDev\BackpackForm\Models\FormbuilderTranslation;
use MedianetDev\BackpackForm\Models\FormField;
use MedianetDev\BackpackForm\Models\FormFieldCondition;
use MedianetDev\BackpackForm\Models\FormFieldTranslation;
use MedianetDev\BackpackForm\Models\FormStep;
use MedianetDev\BackpackForm\Models\FormStepTranslation;

/**
 * Class FormbuilderCrudController
 * @package MedianetDev\BackpackForm\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FormbuilderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        destroy as traitDestroy;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use Field;
    use CrudPermissions;


    public function setup()
    {
        CRUD::setModel(Formbuilder::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/formbuilder');
        CRUD::setEntityNameStrings(
            __('medianet-dev.backpack-form::formbuilder.labels.entity_form'),
            __('medianet-dev.backpack-form::formbuilder.labels.entities_form')
        );
        $this->crud->addButtonFromModelFunction('line', 'entries_list', 'entriesList', 'beginning');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'uniq_id',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.uuid')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.title')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.header',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.header')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.footer',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.footer')),
                'type' => 'text',
            ],
            [
                'name' => 'in_database',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.in_database')),
                'type' => 'boolean', // Changed from 'check' to 'boolean' for better clarity
            ],
            [
                'name' => 'by_mail',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.by_mail')),
                'type' => 'boolean', // Changed from 'check' to 'boolean' for better clarity
            ],
            [
                'name' => 'updated_at',
                'type' => 'datetime',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.updated_at'))
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.created_at'))
            ]
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns([
            [
                'name' => 'uniq_id',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.uuid')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.title')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.description',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.description')),
                'type' => 'html',
            ],
            [
                'name' => 'translation.slug',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.slug')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.header',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.header')),
                'type' => 'text',
            ],
            [
                'name' => 'translation.footer',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.footer')),
                'type' => 'text',
            ],
            [
                'name' => 'text_button',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.text_button')),
                'type' => 'text',
            ],
            [
                'name' => 'in_database',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.in_database')),
                'type' => 'boolean',
            ],
            [
                'name' => 'display_title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_title')),
                'type' => 'boolean',
            ],
            [
                'name' => 'multiple_steps',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.multiple_steps')),
                'type' => 'boolean',
            ],
            [
                'name' => 'display_header',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_header')),
                'type' => 'boolean',
            ],
            [
                'name' => 'display_footer',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_footer')),
                'type' => 'boolean',
            ],
            [
                'name' => 'display_intro',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_intro')),
                'type' => 'boolean',
            ],
            [
                'name' => 'display_captcha',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_captcha')),
                'type' => 'boolean',
            ],
            [
                'name' => 'by_mail',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.by_mail')),
                'type' => 'boolean',
            ],
            [
                'name' => 'mail_to',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.mail_to')),
                'type' => 'text',
            ],
            [
                'name' => 'include_data',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.include_data')),
                'type' => 'boolean',
            ],
            [
                'name' => 'subject_admin',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.subject_admin')),
                'type' => 'text',
            ],
            [
                'name' => 'message_admin',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.message_admin')),
                'type' => 'html',
            ],
            [
                'name' => 'copy_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.copy_user')),
                'type' => 'boolean',
            ],
            [
                'name' => 'field_mail_name',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.field_mail_name')),
                'type' => 'text',
            ],
            [
                'name' => 'subject_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.subject_user')),
                'type' => 'text',
            ],
            [
                'name' => 'message_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.message_user')),
                'type' => 'html',
            ],
            [
                'name' => 'form',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.form')),
                'type' => 'form_builder_preview',
                'view_namespace' => 'medianet.backpack-form::columns',
            ],
            [
                'name' => 'created_at',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.created_at')),
                'type' => 'datetime',
            ],
            [
                'name' => 'updated_at',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.updated_at')),
                'type' => 'datetime',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {

        CRUD::setValidation(FormbuilderRequest::class);

        $translations = $this->getTranslations(
            $this->crud->getOperation(),
            $this->crud->getModel(),
            $this->crud->getCurrentEntry()
        );
        $languages = languages();

        // Language-specific fields
        foreach ($languages as $key => $value) {
            $this->crud->addFields([
                [
                    'name' => "{$key}[title]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.title')),
                    'type' => 'text',
                    'default' => ($translations && isset($translations->translations[$key]))
                        ? $translations->translations[$key]->title
                        : '',
                    'tab' => __($value),
                    'slug_class' => "slug_{$key}"
                ],
                [
                    'name' => "{$key}[slug]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.slug')),
                    'type' => 'text',
                    'slug' => true,
                    'default' => ($translations && isset($translations->translations[$key]))
                        ? $translations->translations[$key]->slug ?? null
                        : '',
                    'tab' => __($value),
                    'attributes' => ['class' => "slug_{$key} form-control"]
                ],
                [
                    'name' => "{$key}[description]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.description')),
                    'type' => 'tinymce',
                    'default' => ($translations && isset($translations->translations[$key]))
                        ? $translations->translations[$key]->description
                        : '',
                    'tab' => __($value),
                    'options' => $this->tinyMceOption()
                ],
                [
                    'name' => "{$key}[text_button]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.text_button')),
                    'type' => 'text',
                    'default' => __('medianet-dev.backpack-form::formbuilder.labels.default_text_button'),
                    'tab' => __($value)
                ],
                [
                    'name' => "{$key}[header]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.header')),
                    'type' => 'tinymce',
                    'options' => $this->tinyMceOption(),
                    'default' => ($translations && isset($translations->translations[$key]))
                        ? $translations->translations[$key]->header
                        : '',
                    'tab' => __($value)
                ],
                [
                    'name' => "{$key}[footer]",
                    'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.footer')),
                    'type' => 'tinymce',
                    'options' => $this->tinyMceOption(),
                    'default' => ($translations && isset($translations->translations[$key]))
                        ? $translations->translations[$key]->footer
                        : '',
                    'tab' => __($value)
                ]
            ]);
        }
        // Create an instance of FormStepCrudController

        // $crud = new FormStepCrudController();
        // $dataCrud =  $crud->getCrudData();

        // Call the setupListOperation method

        // Main form fields
        $this->crud->addFields([
            // Form.io Component Builder (JSON)
            [
                'name' => 'formio_builder',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.formio_builder')),
                'type' => 'form_builder_custom_html',
                'value' => '<div id="formio-builder-container" class="mb-4"> <div id="formio-builder"></div></div>',
                'tab' => __('medianet-dev.backpack-form::formbuilder.tabs.form_io_builder')
            ],

            // Hidden field to store Form.io component JSON
            [
                'name' => 'formio_component',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.formio_component')),
                'type' => 'hidden',
                'attributes' => ['id' => 'formio-component-json'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.tabs.form_io_builder')
            ],

            // Validation rules (JSON)
            [
                'name' => 'validation_rules',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.validation_rules')),
                'type' => 'textarea',
                'attributes' => ['rows' => 5, 'id' => 'validation-rules-json'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.tabs.validation'),
                'hint' => 'Enter validation rules in JSON format'
            ],

            // Config tab fields

            [
                'name' => 'in_database',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.in_database')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'display_title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_title')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'display_intro',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_intro')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'display_captcha',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_captcha')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'display_title',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_title')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'display_header',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_header')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],

            [
                'name' => 'display_footer',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.display_footer')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],
            [
                'name' => 'multiple_steps',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.multiple_steps')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default' => 1,
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.config_tab')
            ],

            // Notifications tab fields
            [
                'name' => 'separator_email_admin',
                'type' => 'custom_html',
                'value' => __('medianet-dev.backpack-form::formbuilder.labels.notification_admin'),
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'by_mail',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.by_mail')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'mail_to',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.mail_to')),
                'hint' => ucfirst(__('medianet-dev.backpack-form::formbuilder.hints.mail_to')),
                'type' => 'text',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'attributes' => ['placeholder' => config('backpack-form.email.to')],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'include_data',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.include_data')),
                'hint' => ucfirst(__('medianet-dev.backpack-form::formbuilder.hints.include_data')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'subject_admin',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.subject_admin')),
                'type' => 'text',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'placeholder' => __('medianet-dev.backpack-form::formbuilder.emails.default_subject', [
                        'app_name' => config('app.name')
                    ])
                ],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'message_admin',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.message_admin')),
                'hint' => ucfirst(__('medianet-dev.backpack-form::formbuilder.hints.message_admin')),
                'type' => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['insert', ['link', 'hr']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ],
                    'placeholder' => __('medianet-dev.backpack-form::formbuilder.emails.message_admin', ['form_title' => ''])
                ],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'separator_email_user',
                'type' => 'custom_html',
                'value' => __('medianet-dev.backpack-form::formbuilder.labels.notification_user'),
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'copy_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.copy_user')),
                'type' => 'select_from_array',
                'options' => __('medianet-dev.backpack-form::formbuilder.labels.bool'),
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'field_mail_name',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.field_mail_name')),
                'hint' => ucfirst(__('medianet-dev.backpack-form::formbuilder.hints.field_mail_name')),
                'type' => 'text',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'subject_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.subject_user')),
                'type' => 'text',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'placeholder' => __('medianet-dev.backpack-form::formbuilder.emails.default_subject', [
                        'app_name' => config('app.name')
                    ])
                ],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ],
            [
                'name' => 'message_user',
                'label' => ucfirst(__('medianet-dev.backpack-form::formbuilder.labels.message_user')),
                'hint' => ucfirst(__('medianet-dev.backpack-form::formbuilder.hints.message_user')),
                'type' => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['insert', ['link', 'hr']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ],
                    'placeholder' => __('medianet-dev.backpack-form::formbuilder.emails.message_user', [
                        'app_name' => config('app.name')
                    ])
                ],
                'tab' => __('medianet-dev.backpack-form::formbuilder.labels.notifications_tab')
            ]
        ]);

        if (
            empty(config('backpack-form.captcha_v3_site_key')) ||
            empty(config('backpack-form.captcha_v3_secret_key'))
        ) {
            $this->crud->field('display_captcha')
                ->hint(__('medianet-dev.backpack-form::formbuilder.hints.captcha_config_error'))
                ->attributes(['disabled' => 'disabled']);
        }

        //$this->addFormioBuilderScript();
    }

    /**
     * Add JavaScript for handling the Form.io builder
     */
    protected function addFormioBuilderScript()
    {
        $this->crud->addField([
            'name' => 'formio_builder_script',
            'type' => 'form_builder_custom_html',
            'tab' => __('medianet-dev.backpack-form::formbuilder.tabs.form_io_builder'),
        ]);
    }
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        // \DB::beginTransaction();
        try {
            // dd(request()->all());
            $response = $this->traitStore();
            $form = $this->crud->getCurrentEntry();
            setAuditFields($form, 'create');

            if (!$form || !$form->id) {
                return back()->withErrors(['message' => __('medianet-dev.backpack-form::formbuilder.validations.form_not_found')]);
            }

            // Save translations in bulk
            $translationsToInsert = [];
            $languages = languages();
            foreach ($languages as $locale => $language) {
                if (request()->has($locale)) {
                    $translationData = request()->input($locale);
                    if (isset($translationData['title']) && !empty($translationData['title'])) {
                        $translationsToInsert[] = [
                            'title' => $translationData['title'],
                            'text_button' => $translationData['text_button'] ?? null,
                            'slug' => $translationData['slug'] ?? null,
                            'description' => $translationData['description'] ?? null,
                            'header' => $translationData['header'] ?? null,
                            'footer' => $translationData['footer'] ?? null,
                            'form_id' => $form->id,
                            'locale' => $locale,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
            if (!empty($translationsToInsert)) {
                FormbuilderTranslation::insert($translationsToInsert);
            }

            // Update form components if available
            if (request()->has('formio_component')) {
                $formComponents = json_decode(request()->formio_component);
                $form->update(['formio_component' => $formComponents]);

                $this->processFormStepsAndFields($form, $formComponents);
            }

            // \DB::commit();
            return $response;
        } catch (\Exception $e) {
            \Log::error('Form creation failed: ' . $e->getMessage());
            return back()->withErrors(['message' => __('medianet-dev.backpack-form::formbuilder.validations.form_creation_failed')]);
        }
    }

    public function update()
    {
        // \DB::beginTransaction();
        try {
            $response = $this->traitUpdate();
            $form = $this->crud->getCurrentEntry();
            setAuditFields($form, 'update');

            if (!$form || !$form->id) {
                return back()->withErrors(['message' => __('medianet-dev.backpack-form::formbuilder.validations.form_not_found')]);
            }

            // Update translations in bulk
            $this->updateTranslation(FormbuilderTranslation::class, 'form_id');

            // Update form components if available
            if (request()->has('formio_component')) {
                $formComponents = json_decode(request()->formio_component);
                $form->update(['formio_component' => $formComponents]);


                $this->processFormStepsAndFields($form, $formComponents);
            }

            // \DB::commit();
            return $response;
        } catch (\Exception $e) {
            // \DB::rollBack();
            \Log::error('Form update failed: ' . $e->getMessage());
            return back()->withErrors(['message' => __('medianet-dev.backpack-form::formbuilder.validations.form_update_failed')]);
        }
    }

    /**
     * Save translations for a given form.
     */
    protected function saveTranslations($form)
    {
        $translationsToInsert = [];
        $languages = languages();
        foreach ($languages as $locale => $language) {
            if (request()->has($locale)) {
                $translationData = request()->input($locale);
                if (isset($translationData['title']) && !empty($translationData['title'])) {
                    $translationsToInsert[] = [
                        'title' => $translationData['title'],
                        'text_button' => $translationData['text_button'] ?? null,
                        'slug' => $translationData['slug'] ?? null,
                        'description' => $translationData['description'] ?? null,
                        'header' => $translationData['header'] ?? null,
                        'footer' => $translationData['footer'] ?? null,
                        'form_id' => $form->id,
                        'locale' => $locale,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        if (!empty($translationsToInsert)) {
            FormbuilderTranslation::insert($translationsToInsert);
        }
    }




   private function processFormStepsAndFields($form, $formComponents)
{
    $currentLocale = App::getLocale();
    $allFields = [];

    // Delete all existing steps and fields for this form
    $existingSteps = FormStep::where('form_id', $form->id)->get();
    foreach ($existingSteps as $step) {
        $fields = FormField::where('form_step_id', $step->id)->get();
        foreach ($fields as $field) {
            FormFieldCondition::where('form_field_id', $field->id)->delete();
            $field->translation()->delete();
            $field->delete();
        }
        $step->translation()->delete();
        $step->delete();
    }

    // Delete standalone fields (without step association)
    $standaloneFields = FormField::where('form_id', $form->id)
                              ->whereNull('form_step_id')
                              ->get();
    foreach ($standaloneFields as $field) {
        FormFieldCondition::where('form_field_id', $field->id)->delete();
        $field->translation()->delete();
        $field->delete();
    }

    // Collect panel and non-panel components
    $panelComponents = [];
    $nonPanelComponents = [];

    foreach ($formComponents as $index => $component) {
        if ($component->type === 'panel') {
            $panelComponents[] = (object)[
                'component' => $component,
                'index' => $index
            ];
        } else {
            $nonPanelComponents[] = $component;
        }
    }

    // 1. Process panel components (which act as steps in the form)
    foreach ($panelComponents as $panelData) {
        $stepFields = $this->processFormStep($form, $panelData->component, $currentLocale, $panelData->index);
        $allFields = array_merge($allFields, $stepFields);
    }

    // 2. Process fields without a panel and add directly to form_fields with null form_step_id
    if (!empty($nonPanelComponents)) {
        $standaloneFields = $this->createStandaloneFields($form, $nonPanelComponents);
        $allFields = array_merge($allFields, $standaloneFields);
    }

    // 3. Process all conditions after all fields are created
    // For panel components
    foreach ($panelComponents as $panelData) {
        $panel = $panelData->component;
        $step = FormStep::where('form_id', $form->id)
            ->where('key', $panel->key)
            ->first();

        if ($step && isset($panel->components) && is_array($panel->components)) {
            foreach ($panel->components as $fieldComponent) {
                $this->processComponentCondition($form, $fieldComponent, $step);
            }
        }
    }

    // For non-panel components
    if (!empty($nonPanelComponents)) {
        foreach ($nonPanelComponents as $component) {
            $this->processComponentCondition($form, $component, null);
        }
    }

    return $allFields;
}

private function processFormStep($form, $panel, $currentLocale, $order)
{
    // Create new step from panel
    $step = new FormStep([
        'is_active' => true,
        'key' => $panel->key,
        'form_id' => $form->id,
        'is_default' => false,
        'order' => $order,
    ]);
    $step->save();

    FormStepTranslation::create([
        'title' => $panel->label,
        'form_step_id' => $step->id,
        'locale' => $currentLocale,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Process fields in the panel if any
    if (isset($panel->components) && is_array($panel->components)) {
        return $this->createStepFields($form, $panel->components, $step);
    }

    return [];
}

private function createStepFields($form, $components, $step)
{
    $fieldsMap = [];

    // Create fields for this step
    foreach ($components as $order => $component) {
        $field = new FormField([
            'form_step_id' => $step->id,
            'form_id' => $form->id,
            'key' => $component->key,
            'type' => $component->type,
            'is_active' => isset($component->isActive) ? $component->isActive : true,
            'is_required' => isset($component->validate) && isset($component->validate->required) ? $component->validate->required : false,
            'order' => isset($component->order) ? $component->order : $order,
        ]);
        $field->save();

        // Store field by key for condition processing
        $fieldsMap[$component->key] = $field;

        // Create field translation
        FormFieldTranslation::create([
            'label' => isset($component->label) ? $component->label : null,
            'placeholder' => isset($component->placeholder) ? $component->placeholder : null,
            'default_value' => isset($component->defaultValue) ? $component->defaultValue : null,
            'description' => isset($component->description) ? $component->description : null,
            'form_field_id' => $field->id,
            'locale' => App::getLocale(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return $fieldsMap;
}

private function createStandaloneFields($form, $components)
{
    $fieldsMap = [];

    // Create standalone fields (not associated with any step)
    foreach ($components as $order => $component) {
        $field = new FormField([
            'form_step_id' => null, // No step association
            'form_id' => $form->id,
            'key' => $component->key,
            'type' => $component->type,
            'is_active' => isset($component->isActive) ? $component->isActive : true,
            'is_required' => isset($component->validate) && isset($component->validate->required) ? $component->validate->required : false,
            'order' => isset($component->order) ? $component->order : $order,
        ]);
        $field->save();

        // Store field by key for condition processing
        $fieldsMap[$component->key] = $field;

        // Create field translation
        FormFieldTranslation::create([
            'label' => isset($component->label) ? $component->label : null,
            'placeholder' => isset($component->placeholder) ? $component->placeholder : null,
            'default_value' => isset($component->defaultValue) ? $component->defaultValue : null,
            'description' => isset($component->description) ? $component->description : null,
            'form_field_id' => $field->id,
            'locale' => App::getLocale(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return $fieldsMap;
}

private function processComponentCondition($form, $component, $step = null)
{
    // Check if component has conditional logic
    if (!isset($component->conditional) || !isset($component->conditional->when)) {
        return;
    }

    // Get the field for this component
    $field = FormField::where('form_id', $form->id)
        ->where('key', $component->key)
        ->first();

    if (!$field) {
        return;
    }

    // Find the field this condition depends on (across all steps)
    $whenField = FormField::where('form_id', $form->id)
        ->where('key', $component->conditional->when)
        ->first();

    if (!$whenField) {
        return;
    }

    // Delete any existing conditions for this field
    FormFieldCondition::where('form_field_id', $field->id)->delete();

    // Create new condition
    $conditionData = [
        'operation' => config('backpack-form.conditional_operations.equal', 'equal'),
        'show' => isset($component->conditional->show) && $component->conditional->show
            ? config('backpack-form.display_condition.show')
            : config('backpack-form.display_condition.hide'),
        'eq' => isset($component->conditional->eq) ? $component->conditional->eq : null,
        'when' => $whenField->id,
        'form_field_id' => $field->id,
        'form_step_id' => $step ? $step->id : null
    ];

    FormFieldCondition::create($conditionData);
}
}

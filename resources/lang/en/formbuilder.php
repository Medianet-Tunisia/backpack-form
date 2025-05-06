<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MedianetDev\BackpackForm Translation Lines
    |--------------------------------------------------------------------------
    */
    'common' => [
        'in_langue' => 'in',
    ],
    'languages' => [
        'fr' => 'French',
        'en' => 'English',
    ],
    'tabs' => [
        'general_information' => 'General Information',
        'form_io_builder' => 'Form Builder',
        'validation' => 'Validation',

    ],
    'labels' => [
        'validation_rules' => 'Validation Rules',
        //
        // Common
        //
        'bool' => [
            0 => 'No',
            1 => 'Yes',
        ],
        'slug' => 'Slug',
        'type' => 'Type',
        'placeholder' => 'Placeholder',
        'is_required' => 'Required',
        'created_at' => 'Creation Date',
        'updated_at' => 'Modification Date',
        'label' => 'Label',

        // New Fields
        'min_length' => 'Minimum Length',
        'max_length' => 'Maximum Length',
        'is_hidden' => 'Hidden',
        'is_readonly' => 'Read-Only',
        'is_unique' => 'Unique',
        'is_disabled' => 'Disabled',
        'help_text' => 'Help Text',
        'class_css' => 'CSS Class',

        //
        // Form builder
        //
        'uuid' => 'Identifier',
        'entity_form' => 'Form',
        'entities_form' => 'Forms',
        'form_tab' => 'Form',
        'config_tab' => 'Form Settings',
        'title' => 'Title',
        'intro' => 'Description',
        'description' => 'Description',
        'slug' => 'Slug',
        'header' => 'Header',
        'footer' => 'Footer',
        'form' => 'Form',
        'form_saved' => 'The form has been saved successfully.',
        'in_database' => 'Save entries in database',
        'by_mail' => 'Send entries by email',
        'display_title' => 'Display form title',
        'display_intro' => 'Display description text',
        'display_header' => 'Display header',
        'display_footer' => 'Display footer',
        'text_button' => 'Button text',
        'default_text_button' => 'Submit Form',
        'view_entries' => 'View Entries',
        'notifications_tab' => 'Notifications',
        'notification_admin' => '<h2>Administrator Notification</h2>',
        'notification_user' => '<hr><h2>User Notification</h2>',
        'copy_user' => 'Send a copy to the user',
        'mail_to' => 'Destination email(s)',
        'include_data' => 'Display form information',
        'subject_admin' => 'Email Subject',
        'message_admin' => 'Email Introduction',
        'subject_user' => 'Email Subject',
        'message_user' => 'Email Introduction',
        'field_mail_name' => 'Name of the form field containing the user\'s email',
        'display_captcha' => 'Enable Google ReCaptcha V3',
    ],
    'hints' => [
        'mail_to' => 'Enter emails separated by commas.',
        'include_data' => 'The form information will be sent with the notification.',
        'message_admin' => 'Email introduction message before form information.',
        'message_user' => 'Email introduction message before form information.',
        'field_mail_name' => 'Indicate the name of the form field containing the user\'s email ("name" line in the field edition).',
        'captcha_config_error' => 'Please configure Google ReCaptcha V3 to enable it.',

        // New Hints
        'min_length' => 'The minimum allowed length for this field.',
        'max_length' => 'The maximum allowed length for this field.',
        'is_hidden' => 'If enabled, this field will be hidden in the form.',
        'is_readonly' => 'If enabled, this field will be read-only.',
        'is_unique' => 'If enabled, each value in this field must be unique.',
        'is_disabled' => 'If enabled, this field will be disabled.',
        'help_text' => 'Help text displayed below the field.',
        'class_css' => 'Custom CSS class to style this field.',
    ],
    'validations' => [
        'form_not_found' => 'No form found for this entry.',
        'success_db' => 'We have received your submission.',
        'mail_to' => 'A destination email is required for emailing.',
        'field_mail_name' => 'The identifier of the field containing the user\'s email is required.',
        'captcha_invalid' => 'Invalid captcha.',
        'title' => 'Title'
    ],
    'emails' => [
        'default_subject' => 'New Form Submission | :app_name',
        'no_data' => 'Fields not filled in',
        'message_admin' => '<p>Hello,</p><p>You have received a new entry in your form: :form_title</p>',
        'message_user' => '<p>Hello,</p><p>Thank you for contacting :app_name.</p><p>We will get back to you as soon as possible.</p>',
        'admin_line_1' => '<p>Here is the content of the form:</p>',
        'user_notif_sent' => '<p>The user has received the notification.</p>',
        'user_data_saved' => '<p>The entry has been saved and is accessible from the administration <a target="_blank" href=":url_admin">here.</a></p>',
        'signature' => '<p>The <a target="_blank" href=":url_site">:app_name</a> team</p>',
        'error_mail_user' => '<p><b>An error occurred while sending to the user. Please check the field name indicated for the email.</b></p>',
        'thead' => [
            'label' => 'Field Name',
            'value' => 'Value Provided'
        ]
    ],
    'steps' => [
        'singular' => 'Step',
        'plural' => 'Steps',
        'config_step_tab' => 'Step Configuration',
    ],
    'formfield' => [
        'singular' => 'Form Field',
        'plural' => 'Form Fields',
        'config_field_tab' => 'Field Settings',
        'config_field_tab_2' => 'Field Settings 2',
        'label' => 'Label',
        'type' => 'Type',
        'placeholder' => 'Placeholder',
        'is_required' => 'Required',
        'form_step' => 'Form Step',

        // New Labels for Missing Fields
        'min_length' => 'Minimum Length',
        'max_length' => 'Maximum Length',
        'is_hidden' => 'Hidden',
        'is_readonly' => 'Read-Only',
        'is_unique' => 'Unique',
        'is_disabled' => 'Disabled',
        'help_text' => 'Help Text',
        'class_css' => 'CSS Class',
    ],

];

<!-- used for heading, separators, etc -->
<link rel="stylesheet" href="{{ asset('vendor/medianet-dev/backpack-form/css/formio.full.min.css') }}">


@include('crud::fields.inc.wrapper_start')
	{!! $field['value'] !!}
@include('crud::fields.inc.wrapper_end')
@push('after_scripts')

<script src="{{ asset('vendor/medianet-dev/backpack-form/js/formio.full.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery === "undefined") {
            console.error("jQuery is not loaded!");
            return;
        }


        jQuery(document).ready(function($) {
            // Wait for Formio to be available
            const checkFormio = setInterval(() => {
                if (typeof Formio !== "undefined") {
                    clearInterval(checkFormio);
                    initFormioBuilder();
                }
            }, 100);


            function initFormioBuilder() {
                console.log("Initializing Form.io Builder");


                // Get the selected field type
                const fieldType = "panel";


                // Get existing component JSON if available (for edit mode)
                let existingComponent = {};
                const existingJson = $("#formio-component-json").val();
                if (existingJson && existingJson.trim() !== "") {
                    try {
                        existingComponent = JSON.parse(existingJson);
                        console.log("Loaded existing component:", existingComponent);
                    } catch (e) {
                        console.error("Error parsing existing component JSON:", e);
                    }
                } else {
                    // Create default component based on selected type
                    existingComponent = createDefaultComponent(fieldType);
                    existingComponent = [existingComponent];
                    console.log("Created default component:", existingComponent);
                }


                // Initialize Form.io builder for the component
                Formio.builder(document.getElementById("formio-builder"), {
                    components: existingComponent
                }, {
                    builder: {
                        basic: false,
                        advanced: false,
                        data: false,

                        layout: false,
                        premium: false,
                        custom: {
                            title: "Component Settings",
                            weight: 0,
                           components: {
                                 textfield: true,
                                 textarea: true,
                                 number: true,
                                 password: true,
                                 checkbox: true,
                                 selectboxes: true,
                                 select: true,
                                 radio: true,
                                 button: true,
                                 email: true,
                                 url: true,
                                 phoneNumber: true,
                                 address: true,
                                 datetime: true,
                                 day: true,
                                 time: true,
                                 currency: true,
                                 signature: true,
                                 file: true,
                                 content: true,
                                 columns: true,
                                 fieldset: true,
                                 panel: true,
                                 table: true,
                                 tabs: true,
                                 well: true,
                                 hidden: true,
                             }
                        }
                    }
                }).then(function(builder) {
                    console.log("Builder initialized");


                    // Listen for changes in the builder
                    builder.on("change", function() {
                        const components = builder.schema.components;

                        if (components && components.length > 0) {
                          //  const component = components[0];
                            const component = components;


                            // Update the hidden input with the component JSON
                            $("#formio-component-json").val(JSON.stringify(component));


                            // Update validation rules based on component settings
                            //updateValidationRules(component);


                            console.log("Component updated:", component);
                        }
                    });


                    // Listen for field type changes
                    $("select[name=\'type\']").change(function() {
                        const newFieldType = $(this).val();
                        console.log("Field type changed to:", newFieldType);


                        // Rebuild the builder with the new component type
                        const defaultComponent = createDefaultComponent(newFieldType);


                        // Keep some properties from the existing component if possible
                        const existingComponent = builder.schema.components[0];
                        if (existingComponent) {
                            defaultComponent.key = existingComponent.key || defaultComponent.key;
                            defaultComponent.label = existingComponent.label || defaultComponent.label;
                            defaultComponent.placeholder = existingComponent.placeholder || defaultComponent.placeholder;
                            defaultComponent.description = existingComponent.description || defaultComponent.description;
                        }


                        builder.form = {
                            components: [defaultComponent]
                        };


                        // Update the builder options to show only the new component type
                        builder.options.builder.custom.components = {
                            [newFieldType]: true
                        };


                        builder.redraw();
                    });


                    // Update key field when label changes
                    $("input[name$=\'[label]\']").change(function() {
                        const label = $(this).val();
                        if (label && builder.schema.components[0]) {
                            // Generate a camelCase key from the label
                            const key = label.toLowerCase()
                                .replace(/[^a-z0-9]/gi, " ")
                                .trim()
                                .split(" ")
                                .map((word, index) => index === 0 ? word : word.charAt(0).toUpperCase() + word.slice(1))
                                .join("");


                            // Update the key field and the component
                            $("input[name=\'key\']").val(key);
                            builder.schema.components[0].key = key;
                            builder.schema.components[0].label = label;
                            builder.redraw();
                        }
                    });


                    // Listen for key field changes
                    $("input[name=\'key\']").change(function() {
                        const key = $(this).val();
                        if (key && builder.schema.components[0]) {
                            builder.schema.components[0].key = key;
                            builder.redraw();
                        }
                    });


                    // Listen for required toggle changes
                    $("input[name=\'is_required\']").change(function() {
                        const required = $(this).prop("checked");
                        if (builder.schema.components[0]) {
                            builder.schema.components[0].validate = builder.schema.components[0].validate || {};
                            builder.schema.components[0].validate.required = required;
                            builder.redraw();
                        }
                    });
                });
            }


            function createDefaultComponent(type) {
                const key = $("input[name=\'key\']").val() || type + Math.floor(Math.random() * 1000);
                const label = $("input[name$=\'[label]\']:first").val() || "Untitled " + type.charAt(0).toUpperCase() + type.slice(1);
                const placeholder = $("input[name$=\'[placeholder]\']:first").val() || "";
                const required = $("input[name=\'is_required\']").prop("checked") || false;


                const component = {
                    type: type,
                    key: key,
                    label: label,
                    placeholder: placeholder,
                    input: true,
                    validate: {
                        required: required
                    }
                };


                // Specific configurations based on component type
                switch (type) {
                    case "select":
                    case "radio":
                    case "selectboxes":
                        component.values = [
                            { label: "Option 1", value: "option1" },
                            { label: "Option 2", value: "option2" },
                            { label: "Option 3", value: "option3" }
                        ];
                        break;
                    case "datetime":
                        component.format = "yyyy-MM-dd hh:mm a";
                        component.enableTime = true;
                        component.enableDate = true;
                        break;
                    case "day":
                        component.dayFirst = false;
                        component.fields = {
                            day: { type: "number", placeholder: "Day" },
                            month: { type: "select", placeholder: "Month" },
                            year: { type: "number", placeholder: "Year" }
                        };
                        break;
                    case "file":
                        component.storage = "base64";
                        component.fileTypes = [".pdf", ".jpg", ".jpeg", ".png", ".doc", ".docx"];
                        component.fileMaxSize = "10MB";
                        break;
                    case "address":
                        component.provider = "google";
                        component.autocompleteUrl = "https://maps.googleapis.com/maps/api/js";
                        break;
                    case "content":
                        component.html = "<p>Content goes here</p>";
                        break;
                }


                return component;
            }


            function updateValidationRules(component) {
                const validationRules = {
                    required: component.validate?.required || false
                };


                // Add other validation properties based on component type
                switch (component.type) {
                    case "textfield":
                    case "textarea":
                        if (component.validate?.minLength) {
                            validationRules.minLength = component.validate.minLength;
                        }
                        if (component.validate?.maxLength) {
                            validationRules.maxLength = component.validate.maxLength;
                        }
                        if (component.validate?.pattern) {
                            validationRules.pattern = component.validate.pattern;
                        }
                        break;
                    case "number":
                        if (component.validate?.min) {
                            validationRules.min = component.validate.min;
                        }
                        if (component.validate?.max) {
                            validationRules.max = component.validate.max;
                        }
                        break;
                    case "email":
                        validationRules.email = true;
                        break;
                    case "file":
                        if (component.fileMaxSize) {
                            validationRules.maxSize = component.fileMaxSize;
                        }
                        if (component.fileTypes && component.fileTypes.length) {
                            validationRules.fileTypes = component.fileTypes;
                        }
                        break;
                }


                // Update the validation rules textarea
                $("#validation-rules-json").val(JSON.stringify(validationRules, null, 2));
            }
        });
    });
    </script>

@endpush

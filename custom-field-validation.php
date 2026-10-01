<?php

/**
 * Ninja Forms
 * Example of server side custom field validation for the WordPress plugin Ninja Forms on submission 
 * In this example limiting to two email domains
 */

add_filter( 'ninja_forms_submit_data', 'custom_ninja_form_validation');
function custom_ninja_form_validation( $form_data ) {
    // Specific form ID (ex/ 123) if targeting one form
    // ninja_forms_submit_data uses $form_data['id'] not $form_data['form_id'] which is used in other cases
    if (123 != $form_data['id']) {
        return $form_data;
    }

    // Your target field number (ex/ 123 - use inspection tool within browser to find)
    // Not the field key/id listed within the form builder
    $field_id = 123;

    if ( isset( $form_data['fields'][$field_id] ) ) {
        $field_value = $form_data['fields'][$field_id]['value'];

        // Perform your custom validation check 
        $main_email = "@test.com";
        $subdomain_email = "@sub.test.com";
        $is_valid = ((str_ends_with($field_value, $main_email)) ||(str_ends_with($field_value, $subdomain_email)));

        if ( !$is_valid ) {
            // Attach error message to stop submission and highlight field
            $form_data['errors']['fields'][$field_id] = 'This value is not allowed. Must end with @test.com or @sub.test.com';
        }
    }

    return $form_data;
}
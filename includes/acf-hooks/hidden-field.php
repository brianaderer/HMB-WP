<?php
function disable_acf_load_field( $field ) {
	$field['disabled'] = 1;
	return $field;
}
$fields = array (
	'message',
	'boat_name',
	'year_make_model',
	'boat_type',
	'beam',
	'full_name',
	'email',
	'phone_number',
	'boat_length_loa',
	'draft',
    'image_uuid',
    'uploaded_by'
);
foreach ( $fields as $field ):
	add_filter('acf/load_field/name=' . $field , 'disable_acf_load_field');
endforeach;

add_action('acf/render_field_settings', 'add_readonly_and_disabled_to_text_field');
function add_readonly_and_disabled_to_text_field( $field ): void {
	acf_render_field_setting( $field, array(
		'label'      => __('Show on Front End?','acf'),
		'instructions'  => 'Resolver must be set up to honor this.',
		'type'      => 'radio',
		'name'      => 'front-end',
		'choices'    => array(
			1        => __("Yes",'acf'),
			0        => __("No",'acf'),
		),
		'layout'  =>  'horizontal',
	));
}

<?php
add_action('acf/init', 'map_block');
function map_block(): void {
	if (function_exists('acf_register_block_type')) {
	acf_register_block_type(array(
		'name'              => 'hmb-map',
		'title'             => __('Map'),
		'description'       => __('Form for Transient Submissions'),
        'supports'          => array( 'anchor' => true ),
	));
	}
}

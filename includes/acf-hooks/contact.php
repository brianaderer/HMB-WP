<?php
add_action('acf/init', 'contact_block');
function contact_block(): void {
	if (function_exists('acf_register_block_type')) {
	acf_register_block_type(array(
		'name'              => 'contact-form',
		'title'             => __('Email Form'),
		'description'       => __('Form for Transient Submissions'),
	));
	}
}

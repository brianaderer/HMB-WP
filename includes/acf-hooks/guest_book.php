<?php
add_action('acf/init', 'register_custom_blocks');
function register_custom_blocks(): void {

	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'guest-book-entry',
			'title'             => __('Guest Book'),
			'description'       => __('Allow Guests to Sign the Guest Book.'),
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'places'),
		));
	}

}
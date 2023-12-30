<?php
add_action('acf/init', 'register_gallery');
function register_gallery(): void {

	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'gallery',
			'title'             => __('Gallery'),
			'description'       => __('Allow Guests to Sign the Guest Book.'),
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'places'),
            'supports'          => array( 'anchor' => true ),
		));
	}

}
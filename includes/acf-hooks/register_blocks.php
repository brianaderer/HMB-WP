<?php
add_action('acf/init', 'guest_book_block');
function guest_book_block(): void {

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
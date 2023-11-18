<?php

add_action('acf/init', 'reviews_block');
function reviews_block(): void {

	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'Reviews',
			'title'             => __('Reviews'),
			'description'       => __('A custom testimonial block.'),
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'reviews'),
		));
	}

}
function logger( mixed $input ): void {
	error_log( print_r( $input, true ) );
}
<?php
add_action('acf/init', 'attractions_block');
function attractions_block(): void {

	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'Attractions',
			'title'             => __('Attractions'),
			'description'       => __('Manage attractions list.'),
			'render_template'   => get_stylesheet_directory() . '/includes/acf-hooks/attractions-block-template.php',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array( 'places'),
		));
	}

}
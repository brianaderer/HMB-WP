<?php
add_action('acf/init', 'register_user_info');
function register_user_info(): void {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'user-info-form',
            'title'             => __('User Info'),
            'description'       => __('Form for Logged In User Management.'),
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'places'),
        ));
    }

}
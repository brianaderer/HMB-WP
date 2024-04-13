<?php
add_action('acf/init', 'register_sign_up');
function register_sign_up(): void {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'sign-up-form',
            'title'             => __('Sign Up'),
            'description'       => __('Form for Logged In User Management.'),
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'places'),
            'supports'          => array( 'anchor' => true ),
        ));
    }

}
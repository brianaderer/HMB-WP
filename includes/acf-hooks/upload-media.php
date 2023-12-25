<?php
add_action('acf/init', 'register_upload');
function register_upload(): void {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'upload-media-form',
            'title'             => __('Upload Media'),
            'description'       => __('Form for users to upload their pictures.'),
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'places'),
        ));
    }

}
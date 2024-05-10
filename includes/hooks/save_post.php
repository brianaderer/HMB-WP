<?php

function my_custom_function_for_specific_type($post_id, $post, $update)
{
    spinupwp_purge_site();
}

add_action('save_post', 'my_custom_function_for_specific_type', 10, 3);


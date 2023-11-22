<?php
function is_rest_api_request(): bool {
	$rest_prefix = trailingslashit( rest_get_url_prefix() );
	return ( str_contains( $_SERVER['REQUEST_URI'], $rest_prefix ) );
}

function is_admin_request(): bool {
	 return str_contains( $_SERVER['HTTP_REFERER'], get_admin_url() );
}

add_filter('acf/pre_save_post', 'my_acf_pre_save_post', 10, 2);
function my_acf_pre_save_post( $post_id, $form ) {
	logger( $form );
	// Create post using $form and update $post_id.
	return $post_id;
}


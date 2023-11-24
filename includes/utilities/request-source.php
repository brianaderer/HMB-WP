<?php
function is_rest_api_request(): bool {
	$rest_prefix = trailingslashit( rest_get_url_prefix() );
	return ( str_contains( $_SERVER['REQUEST_URI'], $rest_prefix ) );
}

function is_admin_request(): bool {
	 return str_contains( $_SERVER['HTTP_REFERER'], get_admin_url() );
}


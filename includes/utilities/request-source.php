<?php
function is_rest_api_request() {
	$rest_prefix = trailingslashit( rest_get_url_prefix() );
	return ( str_contains( $_SERVER['REQUEST_URI'], $rest_prefix ) );
}

function is_acf_update(): bool {
	logger( $_SERVER );
	return true;
}



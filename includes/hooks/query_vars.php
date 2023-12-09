<?php
function themeslug_query_vars( $qvars ) {
	$qvars[]= 'foo';
	return $qvars;
}
add_filter( 'query_vars', 'themeslug_query_vars' );
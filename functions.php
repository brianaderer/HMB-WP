<?php

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', './wp-content/themes/HMB/logs/debug.log' );
function logger( mixed $input ): void {
	error_log( print_r( $input, true ) );
}
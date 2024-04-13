<?php
function add_google_maps_key() {
	$key = $_ENV['GOOGLE_MAPS_KEY'];
	acf_update_setting('google_api_key', $key);
}
add_action('acf/init', 'add_google_maps_key');
<?php
$key = getenv('GOOGLE_MAPS_KEY');
logger($key);
function add_google_maps_key() {
	acf_update_setting('google_api_key', 'xxx');
}
add_action('acf/init', 'add_google_maps_key');
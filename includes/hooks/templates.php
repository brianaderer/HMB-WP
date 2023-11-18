<?php
add_filter('theme_page_templates', 'register_custom_page_templates');
function register_custom_page_templates($templates) {
	$templates['attractions'] = 'Attractions';
	return $templates;
}

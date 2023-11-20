<?php
function my_theme_enqueue_acf_scripts() {
acf_enqueue_scripts();
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_acf_scripts');
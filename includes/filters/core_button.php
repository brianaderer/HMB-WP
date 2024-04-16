<?php
function filter_core_button_block($block_content, $block) {
    if ($block['blockName'] === 'core/button') {
        // Strip HTML tags to get text-only content
        $text_content = wp_strip_all_tags($block_content);
        return $text_content;
    }
    return $block_content;
}

add_filter('render_block', 'filter_core_button_block', 10, 2);

<?php
//add_filter(
//    'register_block_type_args',
//    'change_render_callback_for_query_pagination_numbers',
//    10,
//    2
//);
//
//function change_render_callback_for_query_pagination_numbers( array $settings, string $name ): array {
//      if( $settings['name'] === 'core/heading' ):
//        $settings['render_callback'] = 'render_query_pagination_numbers';
//      endif;
//    return $settings;
//}
//
//function render_query_pagination_numbers( array $attributes, string $content, WP_Block $block ) {
//
//    logger( $attributes );
//    logger( $content );
//
//    return $attributes;
//}
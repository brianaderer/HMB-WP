<?php
add_action( 'graphql_register_types', function() {
    register_graphql_field( 'GeneralSettings', 'siteLogo', [
        'type' => 'String',
        'description' => __( 'Current Wordpress site logo', 'halfmoonbay' ),
        'resolve' => function( $root, $args, $context, $info ) {
        $data = array (
            'logo' => get_site_icon_url(),
        );
            return json_encode( $data , JSON_UNESCAPED_SLASHES);
        }
    ] );
});
<?php
add_action('graphql_register_types', function() {
    register_graphql_field('AcfHmbMap', 'mapFields', [
        'type' => 'String', // Use 'String' type for JSON encoded data
        'description' => 'Fields from ACF gallery block encoded as a JSON string',
        'resolve' => function($root, $args, $context, $info) {
            // Encode data as JSON string
            return json_encode( $root['attrs']['data'], JSON_UNESCAPED_SLASHES);
        }
    ]);
});

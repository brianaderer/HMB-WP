<?php
add_action('graphql_register_types', function () {
    register_graphql_field('CoreImage', 'customAttributes', [
        'type' => 'String',
        'description' => 'Custom attributes for the paragraph block',
        'resolve' => function ($root, $args, $context, $info) {
            // Extract attributes from the block
            $attributes = $root['attrs'];

            // Process and return your custom attributes
            // For example, returning a JSON string of attributes
            return json_encode($attributes);
        },
    ]);
});

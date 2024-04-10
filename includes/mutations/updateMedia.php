<?php
//repush
add_action(/**
 * @throws Exception
 */ 'graphql_register_types', function() {
    $media_fields = [
        'image_uuid' => [
            'type' => 'String',
            'description' => 'UUID of the user who created image',
        ],
        'uploaded_by' => [
            'type' => 'String',
            'description' => 'Plain Text name of the uploader',
        ],
    ];
    // Define the 'GuestBookEntry' object type that corresponds to the ACF field group
    register_graphql_object_type('MediaMeta', [
        'description' => 'Represents a guest book entry with details about a boat',
        'fields' => $media_fields,
    ]);

    // Register an input type for creating or updating guest book entries
    register_graphql_input_type('MediaMetaInput', [
        'description' => 'Input fields for creating or updating a guest book entry',
        'fields' => $media_fields,
    ]);
    // Define the mutation for creating a comment with a guest book entry
    /**
     * @throws Exception
     */
    register_graphql_mutation('createMediaMeta', [
        'inputFields' => [
            'media_id' => [
              'type' => 'Int',
              'description' => 'The media attachment ID to query',
            ],
            'imageMeta' => [
                'type' => 'MediaMetaInput',
                'description' => 'Media Data',
            ],
            // Include any other necessary input fields
        ],
        'outputFields' => [
            'success' => [
                'type' => 'Int',
                'description' => 'Whether the meta was created successfully',
            ],
        ],
        'mutateAndGetPayload' => function($input, $context, $info) {
        $meta = $input['imageMeta'];
        $id = $input['media_id'];
            $success = (
                update_field( 'image_uuid', $meta['image_uuid'], $id ) &&
                update_field( 'uploaded_by', $meta['uploaded_by'], $id )
            );
            return [
                'success' => $success, // or false in case of failure
            ];
        }
    ]);
});

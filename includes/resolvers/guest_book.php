<?php


add_action(/**
 * @throws Exception
 */ 'graphql_register_types', function () {


    register_graphql_object_type('GuestBookContent', [
        'description' => 'The Content of the Guest Book Entry',
        'fields' => [
            'message' => ['type' => 'String'],
            'name' => ['type' => 'String'],
        ]
    ]);

    // Define the compound structure
    register_graphql_object_type('ExtendedGuestBookEntry', [
        'description' => 'An extended guest book entry combining ACF fields and custom fields',
        'fields' => [
            'acfFields' => [
                'type' => 'GuestBookEntryField', // Use the existing ACF-defined type
                'description' => 'Fields managed by ACF',
            ],
            'customFields' => [
                'type' => 'GuestBookContent',
                'description' => 'Custom fields or additional data',
            ],
            'imageGallery' => [
                'type' => ['list_of' => 'Image'],
                'description' => 'Custom image field',
            ],
        ],
    ]);

    register_graphql_field('CreateBlockGuestbook', 'content', [
        'type' => ['list_of' => "ExtendedGuestBookEntry"],
        'description' => 'Custom attributes for the guest book block',
        'resolve' => function ($root, $args, $context, $info) {
            $content = [];
            $args = array(
                'post_type' => 'guest-book-entry',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
            );
            $query = new WP_Query($args);
            if ( $query -> have_posts() ):
                while( $query->have_posts() ):
                    $query -> the_post();
                    $post = $query -> post;
                    $id = $post -> ID;
                    $fields = get_fields( $id );
                    $image_gallery = [];
                    foreach ($fields['image_gallery'] as $image):
                        $image_gallery[] = array(
                            'ID' => $image['ID'],
                            'src' => wp_get_attachment_image_src( $image['ID'], 'medium_large' )[0],
                            'description' => $image['description'],
                            'name' => $image['name'],
                            'caption' => $image['caption'],
                            'alt' => $image['alt'],
                            'title' => $image['title'],
                            'type' => $image['type'],
                        );
                    endforeach;
                    $content[] = array(
                        'acfFields' => [
                            'boat_length_loa' => $fields['boat_length_loa'],
                            'boat_name' => $fields['boat_name'],
                            'boat_type' => $fields['boat_type'],
                            'beam' => $fields['beam'],
                            'draft' => $fields['draft'],
                            'reply' => $fields['reply'],
                            'year_make_model' => $fields['year_make_model'],
                        ],
                        'customFields' => [
                            'message' => $fields['message'],
                            'name' => $fields['full_name'],
                        ],
                        'imageGallery' => $image_gallery,
                    );
                endwhile;
            endif;
            wp_reset_query();
            // Process and return your custom attributes
            // For example, returning a JSON string of attributes
            return $content;
        },
    ]);
});


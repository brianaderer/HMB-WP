<?php
add_action(/**
 * @throws Exception
 */ 'graphql_register_types', function () {
    register_graphql_field('CreateBlockGuestbook', 'content', [
        'type' => ['list_of' => "GuestBookEntry"],
        'description' => 'Custom attributes for the guest book block',
        'resolve' => function ($root, $args, $context, $info) {
            $content = [];
            $args = array(
                'post_type' => 'guest-book-entry',
                'post_status' => 'publish',
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
                        $gallery = array(
                            'ID' => $image['ID'],
                            'src' => $image['url'],
                            'description' => $image['description'],
                            'name' => $image['name'],
                            'caption' => $image['caption'],
                            'alt' => $image['alt'],
                            'title' => $image['title'],
                            'type' => $image['type'],
                        );
                    $image_gallery[] = json_encode( $gallery, true );
                    endforeach;
                    $content[] = array(
                        'boat_name' => $fields['boat_name'],
                        'boat_type' => $fields['boat_type'],
                        'beam' => $fields['beam'],
                        'draft' => $fields['draft'],
                        'full_name' => $fields['full_name'],
                        'message' => $fields['message'],
                        'year_make_model' => $fields['year_make_model'],
                        'return_image_gallery' => $image_gallery,
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


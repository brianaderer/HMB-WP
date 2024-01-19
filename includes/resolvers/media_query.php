<?php
add_action( 'graphql_register_types', function() {
    register_graphql_field( 'RootQuery', 'mediaQuery', [
        'type' => ['list_of' => 'wpImage'],
        'description' => 'Query images by id',
        'args' => [
            'ids' => [
                'type' => ['list_of' => 'Int'],
                'description' => 'An array of the IDs to return',
            ],
        ],
        'resolve' => function ( $root, $args, $context, $info ) {
            $return_images = [];
            if( $args['ids'] ):
                $query_args = array(
                  'post_type' => 'attachment',
                  'post_status' => 'inherit',
                  'orderby' => 'ASC',
                  'post__in' => $args['ids'],
                    'posts_per_page' => -1,
                );

                $query = new WP_Query( $query_args );

                if( $query -> have_posts() ):
                    while( $query -> have_posts() ):
                        $query -> the_post();
                        $post = $query -> post;
                        $id = $post -> ID;
                        $url = wp_get_attachment_url( $id );
                        $caption = wp_get_attachment_caption( $id );
                        $alt = get_post_meta( $id, '_wp_attachment_image_alt', TRUE );
                        if( $url ):
                             $return_images[] = array(
                                'permalink' => $url,
                                 'id' => $id,
                                 'size' => null,
                                 'type' => $post -> post_mime_type,
                                 'caption' => $caption === 'undefined' || $caption === null ? '' : $caption,
                                 'alt' => $alt,
                                 'title' => $post -> post_title,
                                 'timestamp' => $post -> post_date_gmt,
                            );
                        endif;
                    endwhile;
                endif;
            endif;
            return $return_images;
        }
    ] );

    register_graphql_type( 'wpImage', [
        'fields' => [
            'permalink' => [
                'type' => 'String',
                'description' => 'The Permalink',
            ],
            'id' => [
                'type' => 'Int',
                'description' => 'The image type',
            ],
            'size' => [
                'type' => 'String',
                'description' => 'The image thumbnail size if applicable'
            ],
            'type' => [
                'type' => 'String',
                'description' => 'Media Mime type',
            ],
            'caption' => [
                'type' => 'String',
                'description' => 'The Image caption',
            ],
            'alt' => [
                'type' => 'String',
                'description' => 'Media Alt attr',
            ],
            'title' => [
                'type' => 'String',
                'description' => 'String',
            ],
            'timestamp' => [
                'type' => 'String',
                'description' => 'The image timestamp',
            ]
        ],
        'description' => 'An array of WP Media properties',
    ] );
} );


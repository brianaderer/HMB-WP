<?php
add_action('graphql_register_types', function() {
    register_graphql_field('AcfGallery', 'galleryFields', [
        'type' => 'String', // Use 'String' type for JSON encoded data
        'description' => 'Fields from ACF gallery block encoded as a JSON string',
        'resolve' => function($root, $args, $context, $info) {
            $data = ($root['attrs']['data']);
            // Assuming $root is the post object
            $tagline = $data['tagline'];
            $gallery_type = $data['gallery_type'];
            $image_gallery = [];
            foreach ( $data['image_gallery'] as $id ):
                $url = wp_get_attachment_url( $id );
                $image = wp_get_attachment_metadata( $id );
                $image_gallery[] = array(
                  'url' => $url,
                  'caption' => $image['image_meta']['caption'],
                );
            endforeach;

            // Prepare the data to return
            $data = [
                'tagline' => $tagline,
                'image_gallery' => $image_gallery,
                'gallery_type' => $gallery_type,
            ];

            // Encode data as JSON string
            return json_encode($data, JSON_UNESCAPED_SLASHES);
        }
    ]);
});

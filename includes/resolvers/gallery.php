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
            $gallery_paragraph = $data['gallery_paragraph'];
            $image_gallery = [];
            foreach ( $data['image_gallery'] as $id ):
                $url = wp_get_attachment_url( $id );
                $image = wp_get_attachment_metadata( $id );
                $image_alt = get_post_meta($id, '_wp_attachment_image_alt', TRUE);
                $image_title = get_the_title($id);
                $image_gallery[] = array(
                  'url' => $url,
                  'caption' => $image['image_meta']['caption'],
                    'alt' => $image_alt,
                    'title' => $image_title,
                );
            endforeach;

            // Prepare the data to return
            $data = [
                'tagline' => $tagline,
                'imageGallery' => $image_gallery,
                'galleryType' => $gallery_type,
                'galleryParagraph' => $gallery_paragraph,
            ];

            // Encode data as JSON string
            return json_encode($data, JSON_UNESCAPED_SLASHES);
        }
    ]);
});

<?php

namespace HMB\GQL;

use SimplePie\Exception;

class ButtonType{
    public string $value = '';
    public string $link = '';
    public string $target = '';
}
class ImageType {
    public int $iD = 0;
    public string $src = '';
    public string $description = '';
    public string $name = '';
    public string $caption = '';
    public string $alt = '';
    public string $title = '';
    public string $type = '';

    public function fill( int $id ): bool{
        try{
            $this -> iD = $id;
            $this -> src = wp_get_attachment_image_src( $id, 'full' )[0];
            $this -> title = get_the_title($id);
            $this -> caption = wp_get_attachment_caption($id);
            $this -> description = get_post_field('post_content', $id);
            $this -> alt = get_post_meta($id, '_wp_attachment_image_alt', true);
            $this -> type = get_post_mime_type( $id );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
class StandardParagraph {
    public string $heading = '';
    public string $subheading = '';
    public string $body = '';
}

add_action('graphql_register_types', function() {
    register_graphql_object_type('Button', [
        'description' => 'Standard Button',
        'fields' => [
            'value' => [
                'type' => 'String',
                'description' => 'The Text to Print in the Button'
            ],
            'link' => [
                'type' => 'String',
                'description' => 'The target for the link',
            ],
            'target' => [
                'type' => 'String',
                'description' => 'Internal/External',
            ]
        ]
    ]);
    register_graphql_object_type('Image', [
        'description' => 'An image gallery field',
        'fields' => [
            'ID' => ['type' => 'Int'],
            'src' => ['type' => 'String'],
            'description' => ['type' => 'String'],
            'name' => ['type' => 'String'],
            'caption' => ['type' => 'String'],
            'alt' => ['type' => 'String'],
            'title' => ['type' => 'String'],
            'type' => ['type' => 'String'],
        ],
    ]);
    register_graphql_object_type('StandardParagraph', [
        'description' => 'A standard paragraph field',
        'fields' => [
            'heading' => [
                'type' => 'String',
                'description' => 'The headline or Title',
            ],
            'subheading' => [
                'type' => 'String',
                'description' => 'The Sub Title or Sub Heading',
            ],
            'body' => [
                'type' => 'String',
                'description' => 'The paragraph body content'
            ]
        ]
    ]);
});
<?php

namespace HMB\GQL;

class HeroType
{
    public ButtonType $cta;
    public StandardParagraph $text;
    public ImageType $image;

    public function __construct()
    {
        $this -> cta = new ButtonType();
        $this -> text = new StandardParagraph();
        $this -> image = new ImageType();
    }

    public function return_array(): array {
        $array = [
            'text' => [],
            'cta' => [],
            'backgroundImage' => [],
        ];
        $image_keys = get_object_vars( $this -> image );
        $button_keys = get_object_vars( $this -> cta );
        $text_keys = get_object_vars( $this -> text );
        foreach ($image_keys as $key => $value):
            $array['backgroundImage'][$key] = $value;
        endforeach;
        foreach ($button_keys as $key => $value):
            $array['cta'][$key] = $value;
        endforeach;
        foreach ($text_keys as $key => $value):
            $array['text'][$key] = $value;
        endforeach;
        return $array;
    }
}

add_action('graphql_register_types', function () {

    register_graphql_object_type('HeroSlideContent', [
        'description' => 'The Content of the Hero Entry',
        'fields' => [
            'cta' => [
                'type' => 'Button',
                'description' => 'Specs for the CTA',
            ],
            'text' => [
                'type' => 'StandardParagraph',
                'description' => 'The paragraph text field',
            ],
            'BackgroundImage' => [
                'type' => 'Image',
                'description' => 'The background image',
            ]
        ]
    ]);


    register_graphql_field('CreateBlockHeroSection', 'content', [
        'type' => ['list_of' => "HeroSlideContent"],
        'description' => 'Custom attributes for the guest book block',
        'resolve' => function ($root, $args, $context, $info) {
            $content = [];
            $args = array(
                'post_type' => 'hero',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
            );
            $query = new \WP_Query($args);
            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();
                    $post = $query->post;
                    $id = $post->ID;
                    $fields = get_fields($id);
                    $hero_object = new HeroType();
                    $hero_object -> text ->subheading = $fields['subheadline'];
                    $hero_object -> image -> fill( $fields['background_media'] );
                    $hero_object -> cta -> link = $fields['link']['url'];
                    $hero_object -> cta -> value = $fields['link']['title'];
                    $hero_object -> text -> body = $post -> post_content;
                    $hero_object -> text -> heading = $post -> post_title;
                    $content[] = $hero_object ->return_array();
                endwhile;
            endif;
            wp_reset_query();
            // Process and return your custom attributes
            // For example, returning a JSON string of attributes
            return $content;
        }
    ]);
});

<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$key = $attributes['additionalData'];
$json = file_get_contents( 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,caption&access_token=' . $key );
$args = array(
	'post_type' => 'attachment',
	'post_status' => 'inherit',
	'posts_per_page' => -1,
	'meta_query' => array(
		array(
			'key' => 'featured',
			'value' => true,
		)
	)
);
$data = json_decode( $json );
if ( $data ):
	$posts = $data -> data;
else:
	$posts = [];
endif;
$array['posts'] = $posts;
$query = new WP_Query( $args );
if( $query -> have_posts() ):
	while( $query -> have_posts() ):
		$query -> the_post();
		$post = $query -> post;
		$type = ucfirst( explode('/', $post -> post_mime_type )[0] );
		$id = $post -> ID;
		$url = get_attachment_link( $id );
		$object = new StdClass ();
		$object -> id = $id;
		$object -> media_type = $type;
		$object -> media_url = $url;
		$object -> timesstamp = $post -> post_date_gmt;
		$object -> caption = wp_get_attachment_caption( $id ) != 'undefined' ? wp_get_attachment_caption( $id ) : '';
		$array['posts'][] = $object;
	endwhile;
endif;
shuffle( $array['posts'] );
echo json_encode( $array );

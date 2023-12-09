<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$args = array(
	'post_type' => 'review',
	'post_status' => 'publish',
	'order_by' => 'date',
	'order' => 'DESC',
);
$reviews = [];
$posts = new WP_Query( $args );
if( $posts-> have_posts() ):
	while( $posts -> have_posts() ):
		$posts -> the_post();
		 $reviews[] = get_fields ( $posts -> post -> ID );
	endwhile;
endif;
$json = json_encode( $reviews );

echo( $json );


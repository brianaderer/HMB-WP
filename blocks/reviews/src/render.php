<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$headline = $attributes['headline'];
$args = array(
	'post_type' => 'review',
	'post_status' => 'publish',
	'order_by' => 'date',
	'order' => 'DESC',
);
$reviews = array(
	'meta' => [],
	'reviewsData' => [],
);
$posts = new WP_Query( $args );
if( $posts-> have_posts() ):
	while( $posts -> have_posts() ):
		$posts -> the_post();
		 $reviews['reviewsData'][] = get_fields ( $posts -> post -> ID );
	endwhile;
endif;
$reviews['meta']['headline'] = $headline;
$json = json_encode( $reviews );

echo( $json );


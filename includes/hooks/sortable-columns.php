<?php
function register_sortable_columns( $columns ) {
	$columns['taxonomy-place-category'] = 'Place Category';
	return $columns;
}
add_filter( 'manage_edit-attractions_sortable_columns', 'register_sortable_columns' );



add_filter( 'manage_attractions_posts_columns', 'attractions_posts_columns' );
function attractions_posts_columns( $columns ) {
	$columns['custom_tags'] = __( 'Tags', 'hmbmarina' );
	return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_attractions_posts_custom_column' , 'custom_attractions_column', 10, 2 );
function custom_attractions_column( $column, $post_id ): void {
	$tags = get_field( 'tags', $post_id );
	$return = [];
	/** @var $tag WP_Term */
	foreach ( $tags as $tag ):
			$return[] = $tag -> name;
		endforeach;
	echo( implode(', ', $return ) );
}

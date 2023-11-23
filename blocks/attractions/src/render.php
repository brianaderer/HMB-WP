<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php

//logger( $attributes );
/**
 * Setup query to show the ‘attractions’ post type with ‘8’ posts.
 */
$args = array(
	'post_type' => 'attractions',
	'post_status' => 'publish',
	'posts_per_page' => 8,
	'orderby' => 'date',
	'order' => 'ASC',
);
//@TODO this query could be optimized
$query = new WP_Query( $args );
$groups = acf_get_field_groups( array( 'post_type' => $args['post_type'] ) );
acf_form_head();
if( is_graphql_http_request() ):
	$array = [];
			if( $query -> have_posts() ):
			while( $query -> have_posts() ):
					$query -> the_post();
					$post = $query -> post;
					$return_array = get_fields( $post -> ID );
					logger( $return_array );
					$return_array[ 'title' ] = $post -> post_title;
					$array[] = json_encode( $return_array );
				endwhile;
				esc_html_e( json_encode( $array ) , 'dynamic' );
			endif;
elseif( is_admin_request() && is_rest_api_request() ):
	?>

	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php
		if( $query -> have_posts() ):
			while( $query -> have_posts() ):
				$query -> the_post();
				$id = $query -> post -> ID;

				$return = array( 'id' => $id, 'data' => get_fields( $id ) );
				logger( $return );
				// Assuming you know the ID or key of the ACF field group you want to use
				$field_group_key = $groups[0]['key'];

				// ACF form arguments
				$options = array(
					'post_title' => true,
					'post_id' => $id, // Use the current post ID
					'field_groups' => array( $field_group_key ), // Replace with your actual field group key
					'return' => '', // URL to redirect to on form submission
					'submit_value' => 'Update', // Text for the submit button
					'uploader' => 'wp'
				);

				// Display the form
				acf_form( $options );
				?>
			<?php
			endwhile;
		endif;
		?>
	</p>
	<?php
endif
?>


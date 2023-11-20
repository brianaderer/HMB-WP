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
if( is_graphql_http_request() ):
	$array = [];
			if( $query -> have_posts() ):
			while( $query -> have_posts() ):
					$query -> the_post();
					$post = $query -> post;
					$array[] = json_encode( get_fields( $post -> ID ) );
				endwhile;
				esc_html_e( json_encode( $array ) , 'dynamic' );
			endif;
endif;
if( is_user_logged_in() ):
	?>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php
		if( $query -> have_posts() ):
			while( $query -> have_posts() ):
				$query -> the_post();
				$id = $query -> post -> ID;

				$return = array( 'id' => $id, 'data' => get_fields( $id ) );
				// Assuming you know the ID or key of the ACF field group you want to use
				$field_group_key = $groups[0]['key']; // Replace with your actual field group key

				// ACF form arguments
				$options = array(
					'post_id' => $id, // Use the current post ID
					'field_groups' => array( $field_group_key ), // Replace with your actual field group key
					'return' => '', // URL to redirect to on form submission
					'submit_value' => 'Update' // Text for the submit button
				);

				// Display the form
				acf_form_head(); // Include necessary ACF form head elements
				acf_form( $options );
				//logger($return);
				?>
			<?php
			endwhile;
		endif;
		?>
	</p>
	<?php
endif
?>


<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * Setup query to show the ‘attractions’ post type with ‘8’ posts.
 */

$args = array(
	'post_type' => 'attractions',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'ASC',
);
//@TODO this query could be optimized
$query = new WP_Query( $args );
$groups = acf_get_field_groups( array( 'post_type' => $args['post_type'] ) );
acf_form_head();
if( is_graphql_http_request() ):
	$array = [];
	if ($query->have_posts()):
		while ($query->have_posts()):
			$query->the_post();
			$post = $query->post;

			// Get ACF fields and other post data
			$return_array = get_fields($post->ID);
			$return_array['title'] = $post->post_title;
			$return_array['id'] = $post->ID;

			// Check if 'location' exists
			if (empty($return_array['location'])) {
				continue; // Skip if 'location' is missing
			}

			// Fetch the 'location_data' post meta field
			$location_data = get_post_meta($post->ID, 'location_data', true);
			$place_id = $return_array['location']['place_id'];

			// Log a message if 'location_data' is empty
			if (empty($location_data) || $location_data -> place_id !== $place_id) {
				try{
					$location = $return_array['location'];
					$destination = $location['lat'] . ', ' . $location['lng'];
					logger($destination);
					$response = get_route_distance($destination);
					$object = json_decode($response);
					if( $object -> meta -> code  === 200 ):
						$data = $object -> routes;
						$data -> place_id = $place_id;
						update_post_meta( $post -> ID, 'location_data', $data );
						$return_array['distance'] = $data;
					endif;
				} catch (Exception $e){
					logger($e);
				}
			} else {
				$return_array['distance'] = $location_data;
			}

			// Append to the array
			$array[] = $return_array;
		endwhile;

		// Encode the array to JSON and output it
		$json = htmlspecialchars_decode(json_encode($array));
		echo $json;
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


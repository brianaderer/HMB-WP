<?php
add_action('graphql_register_types', function() {
	$boat_type_fields = [
		'boat_name' => [
			'type' => 'String',
			'description' => 'Name of the boat',
		],
		'boat_type' => [
			'type' => 'String',
			'description' => 'Type or class of the boat',
		],
		'draft' => [
			'type' => 'Float',
			'description' => 'Draft of the boat in meters or feet',
		],
		'year_make_model' => [
			'type' => 'String',
			'description' => 'Year, make, and model of the boat',
		],
		'beam' => [
			'type' => 'Float',
			'description' => 'Beam width of the boat',
		],
		'boat_length_loa' => [
			'type' => 'Float',
			'description' => 'Length of the Boat',
		],
		// Include any additional fields from your ACF field group as needed
	];
	// Define the 'GuestBookEntry' object type that corresponds to the ACF field group
	register_graphql_object_type('GuestBookEntry', [
		'description' => 'Represents a guest book entry with details about a boat',
		'fields' => $boat_type_fields,
	]);

	// Register an input type for creating or updating guest book entries
	register_graphql_input_type('GuestBookEntryInput', [
		'description' => 'Input fields for creating or updating a guest book entry',
		'fields' => $boat_type_fields,
	]);
	// Define the mutation for creating a comment with a guest book entry
	register_graphql_mutation('createCommentWithGuestBookEntry', [
		'inputFields' => [
			'content' => [
				'type' => 'String',
				'description' => 'Content of the comment',
			],
			'commentOn' => [
				'type' => 'Int',
				'description' => 'ID of the post to comment on',
			],
			'guestBookEntry' => [
				'type' => 'GuestBookEntryInput',
				'description' => 'Guest book entry data',
			],
			// Include any other necessary input fields
		],
		'outputFields' => [
			'success' => [
				'type' => 'Int',
				'description' => 'Whether the comment was created successfully',
			],
//			'comment' => [
//				'type' => 'Comment',
//				'description' => 'The created comment',
//			],
			// Include any other necessary output fields
		],
		'mutateAndGetPayload' => function($input, $context, $info) {
			// Logic to create a comment and save guest book entry data
			// Use $input['content'], $input['commentOn'], $input['guestBookEntry'], etc.

            $page = $input['commentOn'];
			$args = array(
				'comment_post_ID' => $page,
				'comment_type' => 'Guest Book Entry',
				'comment_approved' => 0,
				'comment_content' => $input['content'],
				'comment_meta' => $input['guestBookEntry'],
			);
			$success = wp_insert_comment( $args );
			// Return the results (success status, created comment, etc.)
			return [
				'success' => $success, // or false in case of failure
			];
		}
	]);
});

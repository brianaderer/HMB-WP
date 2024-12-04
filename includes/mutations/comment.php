<?php
add_action( 'graphql_register_types', function() {
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
		'full_name' => [
			'type' => 'String',
			'description' => 'Full name of submitter'
		],
		'email' => [
			'type' => 'String',
			'description' => 'Email of submitter',
		],
		'phone_number' => [
			'type' => 'String',
			'description' => 'Phone number of submitter',
		],
		'message' => [
			'type' => 'String',
			'description' => 'The entry itself',
		],
		'reply' => [
			'type' => 'String',
			'description' => 'The entry itself',
		],
		'image_gallery' => [
			'type' => ['list_of' => 'Int'],
			'description' => 'The images to associate with the Guest Book Entry',
		],
        'return_image_gallery' => [
            'type' => ['list_of' => 'String'],
            'description' => 'The populated returned image list',
        ],
	];
	// Define the 'GuestBookEntry' object type that corresponds to the ACF field group
	register_graphql_object_type('GuestBookEntryMutation', [
		'description' => 'Represents a guest book entry with details about a boat',
		'fields' => $boat_type_fields,
	]);

	// Register an input type for creating or updating guest book entries
	register_graphql_input_type('GuestBookEntryInput', [
		'description' => 'Input fields for creating or updating a guest book entry',
		'fields' => $boat_type_fields,
	]);
	// Define the mutation for creating a comment with a guest book entry
	/**
	 * @throws Exception
	 */
	register_graphql_mutation('createGuestBookEntryMutation', [
		'inputFields' => [
			'title' => [
				'type' => 'String',
				'description' => 'The title for the post',
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
		],
		'mutateAndGetPayload' => function($input, $context, $info) {
			// Logic to create a comment and save guest book entry data
			// Use $input['content'], $input['commentOn'], $input['guestBookEntry'], etc.

			$args = array(
				'post_type' => 'guest-book-entry',
				'post_title' => $input['title'],
				'post_status' => 'pending',
				'meta_input' => $input['guestBookEntry'],
			);
			$success = wp_insert_post( $args );
			// Return the results (success status, created comment, etc.)
			return [
				'success' => $success, // or false in case of failure
			];
		}
	]);
});

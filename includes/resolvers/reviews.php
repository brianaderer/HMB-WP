<?php
add_action('graphql_register_types', function() {
	register_graphql_field('CreateBlockReviews', 'foo', [
		'type' => 'String', // Define the return type of your field
		'description' => 'A field that accepts an argument',
		'args' => [
			'myArgument' => [
				'type' => 'String', // Define the type of the argument
				'description' => 'An argument for the foo field',
			],
		],
		'resolve' => function($root, $args, $context, $info) {
			// Access the argument using $args['myArgument']
			$myArgument = $args['myArgument'] ?? null;

			// Your logic to handle the argument and return a result
			return "Result of foo with argument: " . $myArgument;
		}
	]);
});

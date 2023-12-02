<?php
function resolve_acf_group_fields( string $field_group_key ):array {

	$fields = acf_get_fields( $field_group_key );
	$result = [];
			foreach ( $fields as $field ) {
				$choices = null;
				$placeholder = null;
				if( array_key_exists( 'choices', $field ) ):
					$choices = $field['choices'];
				endif;
				if( array_key_exists( 'placeholder', $field ) ):
					$placeholder = $field['placeholder'];
				endif;
				if( array_key_exists( 'required', $field ) ):
					$required = $field['required'];
				endif;
				if( array_key_exists( 'front-end', $field ) ):
					$front_end = $field['front-end'];
				else:
					$front_end = 1;
				endif;
			$result[ $field['name'] ] = array(
				'label' => $field['label'],
				'value' => $field['value'],
				'options' => $choices,
				'type'  => $field['type'],
				'placeholder' => $placeholder,
				'display' => $front_end,
				'required' => $required,
			);
		}
return $result;
}
add_action( 'graphql_register_types', function() {
	try{
		register_graphql_field( 'AcfGuestBookEntry', 'guestBookData', [
			'type' => 'String',
			'description' => __( 'Expose ACF Generated Guest Book Form in the GQL Schema', 'halfmoonbay' ),
			'resolve' => function( $root, $args, $context, $info ) {
				$field_group_key = "group_6563da4293370"; // Replace with your field group key
				return json_encode( resolve_acf_group_fields( $field_group_key ) );
			}
		] );
	}
	catch (Exception $e){
		logger( $e );
	}
	try{
	register_graphql_field( 'AcfTransientContactForm', 'contactData', [
		'type' => 'String',
		'description' => __( 'Expose ACF Generated Contact Form in the GQL Schema', 'halfmoonbay' ),
		'resolve' => function( $root, $args, $context, $info ) {
			$field_group_key = "group_6558e578f3a2b"; // Replace with your field group key
			return json_encode( resolve_acf_group_fields( $field_group_key ) );
		}
	] );
	}
	catch (Exception $e){
		logger( $e );
	}
});
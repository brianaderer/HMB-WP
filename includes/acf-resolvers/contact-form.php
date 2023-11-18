<?php
function resolve_acf_group_fields():array {
	$field_group_key = "group_6558e578f3a2b"; // Replace with your field group key
	$fields = acf_get_fields( $field_group_key );
	$result = [];
			foreach ( $fields as $field ) {
				$choices = null;
				if( array_key_exists( 'choices', $field ) ):
					$choices = $field['choices'];
				endif;
			$result[ $field['name'] ] = array(
				'label' => $field['label'],
				'value' => $field['value'],
				'options' => $choices,
				'type'  => $field['type'],
				'placeholder' => $field['placeholder'],
			);
		}
return $result;
}
add_action( 'graphql_register_types', function() {
	$result = resolve_acf_group_fields();
	try{
	register_graphql_field( 'AcfTransientContactForm', 'contactData', [
		'type' => 'String',
		'description' => __( 'Expose ACF Generated Contact Form in the GQL Schema', 'replace-with-your-textdomain' ),
		'resolve' => function( $root, $args, $context, $info ) {
			return json_encode( resolve_acf_group_fields() );
		}
	] );
	}
	catch (Exception $e){
		logger( $e );
	}
});
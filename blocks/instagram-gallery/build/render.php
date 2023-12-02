<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$key = $attributes['additionalData'];
$json = file_get_contents( 'https://graph.instagram.com/me/media?fields=id,caption&access_token=' . $key );
$data = json_decode( $json );
$posts = $data -> data;
if ( $posts ):
	foreach ( $posts as $post ):
		logger( $post );
	endforeach;
endif;
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( json_encode( $data -> data ) ); ?>
</p>

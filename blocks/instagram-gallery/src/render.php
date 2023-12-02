<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
logger($attributes);
$json = file_get_contents( 'https://graph.instagram.com/me/media?fields=id,caption&access_token=IGQWRPQjdlRk11UWFaajNWSzBwTS1FaklaaEtOaE1WT0ZA3REZAGUU85dVR5d0xpTWpjNTRGRlJvd0xmbXBiQjBWeXVJVVpDbF9DbmhWcFgyWUVyQ1pTd0xoWVY5NVFiakdoYkpKRGlwX0VLWVA1WnZALOU9TbGVvM0EZD' );
$data = json_decode( $json );
$posts = $data -> data;
if ( $posts ):
	foreach ( $posts as $post ):
		logger( $post -> id );
	endforeach;
endif;
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( 'Instagram Gallery – hello from a dynamic block!', 'instagram-gallery' ); ?>
</p>

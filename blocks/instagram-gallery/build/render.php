<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$key = $attributes['additionalData'];
$json = file_get_contents( 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,caption&access_token=' . $key );
$data = json_decode( $json );
if ( $data ):
	$posts = $data -> data;
	else:
	$posts = [];
endif;
$array['posts'] = $posts;
?>
<?php echo json_encode( $array ); ?>

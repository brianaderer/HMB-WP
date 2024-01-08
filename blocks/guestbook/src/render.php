<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>

<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( 'Guest Book – hello from a dynamic block!', 'guestbook' ); ?>
</p>

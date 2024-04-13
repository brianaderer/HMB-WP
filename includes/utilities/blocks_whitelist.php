<?php
/**
 * Block whitelist
 * Only allow certain blocks to be used
 */

add_filter( 'allowed_block_types', 'our_allowed_block_types' );

function our_allowed_block_types( $allowed_blocks ) {

    return array(
        'acf/contact-form',
        'acf/gallery',
        'acf/guest-book-entry',
        'acf/hmb-map',
        'acf/sign-up-form',
        'acf/upload-media-form',
        'acf/userinfo-form',
        'core/button',
        'core/buttons',
        'core/column',
        'core/columns',
        'core/heading',
        'core/image',
        'core/list',
        'core/list-item',
        'core/media-text',
        'core/paragraph',
        'core/separator',
        'create-block/attractions',
        'create-block/guestbook',
        'create-block/instagram-gallery',
        'create-block/reviews',
    );

}
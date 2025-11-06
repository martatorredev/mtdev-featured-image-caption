<?php
/**
 * Plugin Name: MTDev Featured Image Caption
 * Description: Displays the caption of the featured image under the Featured Image block on single posts.
 * Version:     1.0.0
 * Author:      Marta Torre
 * Author URI:  https://martatorre.dev
 * Text Domain: mtdev-featured-image-caption
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add caption to core/post-featured-image block on single posts.
 */
function mtdev_add_caption_to_post_featured_image_block( $block_content, $block ) {

	// Only frontend.
	if ( is_admin() ) {
		return $block_content;
	}

	// Only the Featured Image block.
	if ( ! isset( $block['blockName'] ) || 'core/post-featured-image' !== $block['blockName'] ) {
		return $block_content;
	}

	// Only single posts for now.
	if ( ! is_singular( 'post' ) ) {
		return $block_content;
	}

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return $block_content;
	}

	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( ! $thumbnail_id ) {
		return $block_content;
	}

	$caption = wp_get_attachment_caption( $thumbnail_id );
	if ( ! $caption ) {
		return $block_content;
	}

	// Avoid duplicating figcaption.
	if ( false !== strpos( $block_content, '<figcaption' ) ) {
		return $block_content;
	}

	$figcaption = '<figcaption class="mtdev-featured-image-caption">' . esc_html( $caption ) . '</figcaption>';

	// Normalmente el bloque ya viene con <figure>, inyectamos dentro.
	if ( false !== strpos( $block_content, '</figure>' ) ) {
		$block_content = str_replace( '</figure>', $figcaption . '</figure>', $block_content );
	} else {
		// Fallback por si acaso.
		$block_content = '<figure class="wp-block-post-featured-image mtdev-featured-image-figure">' . $block_content . $figcaption . '</figure>';
	}

	return $block_content;
}
add_filter( 'render_block', 'mtdev_add_caption_to_post_featured_image_block', 10,_

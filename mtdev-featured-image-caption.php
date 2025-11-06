<?php

/**
 * Plugin Name: MTDev Featured Image Caption
 * Plugin URI:  https://martatorre.dev
 * Description: Displays the caption of the featured image under the Featured Image block on single posts.
 * Version:     1.0.0
 * Author:      Marta Torre
 * Author URI:  https://martatorre.dev
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mtdev-featured-image-caption
 * Requires at least: 6.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 */


if (! defined('ABSPATH')) {
    exit;
}

/**
 * Append accessible figcaption to the Featured Image block.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Block data.
 * @return string
 */
function mtdev_featured_image_caption_render($block_content, $block)
{

    if (is_admin()) {
        return $block_content;
    }

    if (empty($block['blockName']) || 'core/post-featured-image' !== $block['blockName']) {
        return $block_content;
    }

    if (! is_singular('post')) {
        return $block_content;
    }

    if (! is_string($block_content) || '' === $block_content) {
        return $block_content;
    }

    $post_id = get_the_ID();

    if (! $post_id) {
        return $block_content;
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);

    if (! $thumbnail_id) {
        return $block_content;
    }

    $caption = wp_get_attachment_caption($thumbnail_id);

    if (! is_string($caption) || '' === trim($caption)) {
        return $block_content;
    }

    if (false !== strpos($block_content, '<figcaption')) {
        return $block_content;
    }

    $caption_id = 'mtdev-featured-image-caption-' . $thumbnail_id;

    $figcaption = sprintf(
        '<figcaption id="%1$s" class="mtdev-featured-image-caption">%2$s</figcaption>',
        esc_attr($caption_id),
        esc_html($caption)
    );

    // If there is already a figure, inject aria-describedby and the caption.
    if (false !== strpos($block_content, '<figure') && false !== strpos($block_content, '</figure>')) {

        if (false === strpos($block_content, 'aria-describedby=')) {
            $block_content = preg_replace(
                '/<figure\b/',
                '<figure aria-describedby="' . esc_attr($caption_id) . '"',
                $block_content,
                1
            );
        }

        return str_replace('</figure>', $figcaption . '</figure>', $block_content);
    }

    // Fallback: wrap content in a new figure.
    $figure_open = sprintf(
        '<figure class="wp-block-post-featured-image mtdev-featured-image-figure" aria-describedby="%s">',
        esc_attr($caption_id)
    );

    return $figure_open . $block_content . $figcaption . '</figure>';
}
add_filter('render_block', 'mtdev_featured_image_caption_render', 10, 2);

/**
 * Enqueue plugin stylesheet.
 */
function mtdev_featured_image_caption_enqueue_styles()
{

    if (! is_singular('post')) {
        return;
    }

    wp_enqueue_style(
        'mtdev-featured-image-caption',
        plugin_dir_url(__FILE__) . 'assets/css/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'mtdev_featured_image_caption_enqueue_styles');

=== MTDev Featured Image Caption ===
Contributors: martatorre
Tags: featured image, caption, accessibility, gutenberg, blocks
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds accessible captions under the featured image in single posts using the Gutenberg block editor.

== Description ==

MTDev Featured Image Caption automatically adds the image caption below the Featured Image block (`core/post-featured-image`) on single posts. It uses the caption field from the WordPress media library and ensures accessible markup by linking the figure and figcaption through `aria-describedby`.

== Features ==

* Works with block themes (Full Site Editing).
* Automatically displays the media caption under the featured image.
* Accessible HTML structure with `figure` and `figcaption`.
* Lightweight – no extra dependencies or admin settings.
* Developer-friendly and easy to extend.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install via the Plugins screen.
2. Activate **MTDev Featured Image Caption** through the Plugins menu.
3. Edit any post, set a featured image with a caption in the Media Library.
4. View the post on the frontend to see the caption displayed below the featured image.

== Frequently Asked Questions ==

= Does it work with classic themes? =
No, this plugin targets block themes using the `core/post-featured-image` block.

= Can I use it on pages or custom post types? =
Yes — you can modify the condition inside the plugin to include other post types.

== Changelog ==

= 1.0.0 =
* Initial release: accessible captions for featured images.

== Upgrade Notice ==

= 1.0.0 =
First stable version.

== Credits ==

Developed by [Marta Torre](https://martatorre.dev)

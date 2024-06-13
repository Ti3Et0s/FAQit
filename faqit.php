<?php

/**
 * Plugin Name:       faqit
 * Description:       faqit is the ultimate WordPress FAQ plugin, simplifying the creation of beautiful, customizable, and SEO-friendly FAQ sections. Boost user engagement, improve your website's search visibility with automatic schema markup, and elevate your WordPress experience.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       faqit
 *
 * @package CreateBlock
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function init_faq_it_block()
{
	// Register block editor script.
	wp_register_script(
		'faqit-block-editor-script',
		plugins_url('build/index.js', __FILE__),
		array('wp-blocks', 'react', 'wp-i18n', 'wp-block-editor'),
		filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
	);

	// Register block frontend script.
	wp_register_script(
		'faqit-block-view-script',
		plugins_url('build/view.js', __FILE__),
		array('wp-element'),
		filemtime(plugin_dir_path(__FILE__) . 'build/view.js'),
		true
	);

	// Register block frontend script.
	wp_register_script(
		'faqit-block-frontend-script',
		plugins_url('src/js/script.js', __FILE__),
		array('wp-element'),
		filemtime(plugin_dir_path(__FILE__) . 'src/js/script.js'),
		true
	);

	// Register block frontend styles.
	wp_register_style(
		'faqit-block-style',
		plugins_url('build/style-index.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'build/style-index.css')
	);

	// Register editor styles.
	wp_register_style(
		'faqit-block-editor-style',
		plugins_url('build/index.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'build/index.css')
	);

	// Register the block type with translated name and description
	register_block_type(__DIR__ . '/build', array(
		'editor_script' => 'faqit-block-editor-script',
		'script'        => 'faqit-block-frontend-script',
		'style'         => 'faqit-block-style',
		'editor_style'  => 'faqit-block-editor-style',
		'attributes'    => array(
			'faqs' => array(
				'type'    => 'array',
				'default' => array(),
			),
		)
	));
}
add_action('init', 'init_faq_it_block');


function faq_it_block_render_json_ld($attributes)
{
	if (!is_singular()) {
		return;
	}

	$questions = isset($attributes['questions']) ? $attributes['questions'] : array();

	$faq_schema = array(
		"@context"    => "https://schema.org",
		"@type"       => "FAQPage",
		"mainEntity" => array_map(function ($item) {
			return array(
				"@type"          => "Question",
				"name"           => wp_strip_all_tags($item['question']),
				"acceptedAnswer" => array(
					"@type" => "Answer",
					"text"  => wp_strip_all_tags($item['answer']),
				),
			);
		}, $questions),
	);

	echo '<script type="application/ld+json">' . wp_json_encode($faq_schema) . '</script>';
}
add_action('wp_head', 'faq_it_block_render_json_ld');

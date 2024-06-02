<?php

/**
 * Plugin Name:       FAQit
 * Description:       FAQit is the ultimate WordPress FAQ plugin, simplifying the creation of beautiful, customizable, and SEO-friendly FAQ sections. Boost user engagement, improve your website's search visibility with automatic schema markup, and elevate your WordPress experience.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       FAQit
 *
 * @package CreateBlock
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$textDomain = 'FAQit';
function create_block_my_faq_block_init()
{
	// Load plugin text domain for translations
	load_plugin_textdomain('my-faq-block', false, dirname(plugin_basename(__FILE__)) . '/languages/');

	// Get the translated plugin name and description
	$plugin_name = __('My Faq Block', 'my-faq-block');
	$plugin_description = __('Example block scaffolded with Create Block tool.', 'my-faq-block');

	// Register block editor script.
	wp_register_script(
		'create-block-my-faq-block-editor-script',
		plugins_url('build/index.js', __FILE__),
		array('wp-blocks', 'react', 'wp-i18n', 'wp-block-editor'),
		filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
	);

	// Register block frontend script.
	wp_register_script(
		'create-block-my-faq-block-view-script',
		plugins_url('build/view.js', __FILE__),
		array('wp-element'),
		filemtime(plugin_dir_path(__FILE__) . 'build/view.js'),
		true
	);

	// Register block frontend script.
	wp_register_script(
		'faq-block-frontend-script',
		plugins_url('src/js/script.js', __FILE__),
		array('wp-element'),
		filemtime(plugin_dir_path(__FILE__) . 'src/js/script.js'),
		true
	);

	// Register block frontend styles.
	wp_register_style(
		'create-block-my-faq-block-style',
		plugins_url('build/style-index.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'build/style-index.css')
	);

	// Register editor styles.
	wp_register_style(
		'create-block-my-faq-block-editor-style',
		plugins_url('build/index.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'build/index.css')
	);

	// Register the block type with translated name and description
	register_block_type(__DIR__ . '/build', array(
		'editor_script' => 'create-block-my-faq-block-editor-script',
		'script'        => 'faq-block-frontend-script',
		'style'         => 'create-block-my-faq-block-style',
		'editor_style'  => 'create-block-my-faq-block-editor-style',
		'attributes'    => array(
			'faqs' => array(
				'type'    => 'array',
				'default' => array(),
			),
		),
		'title'         => $plugin_name, // Set translated plugin name
		'description'   => $plugin_description, // Set translated plugin description
	));
}
add_action('init', 'create_block_my_faq_block_init');


function my_faq_block_render_json_ld($attributes)
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
add_action('wp_head', 'my_faq_block_render_json_ld');

function myguten_set_script_translations()
{
	wp_set_script_translations('my-faq-block-script', 'my-faq-block', plugin_dir_path(__FILE__) . 'languages');
}
add_action('init', 'myguten_set_script_translations');

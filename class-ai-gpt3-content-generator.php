<?php
/**
 * Plugin Name: AI GPT-3 Content Generator
 * Plugin URI: https://miniorange.com/
 * Description: GPT based AI content writer for WordPress, create content, generate images, automatic content creator ChatGPT content writer.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * License: MIT/Expat
 * License URI: https://docs.miniorange.com/mit-license
 * Text Domain: ai-gpt3-content-generator
 * Domain Path: /languages
 *
 * @package ai-gpt3-content-generator
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'helper' . DIRECTORY_SEPARATOR . 'class-moai-utils.php';
require_once 'helper' . DIRECTORY_SEPARATOR . 'class-moai-initializer.php';

/**
 * Main class for the plugin.
 */
class AI_GPT3_Content_Generator {

	/**
	 * Takes care of initializing the plugin.
	 */
	public function __construct() {
		$moai_initializer = new MOAI_Initializer();
		$moai_initializer->moai_include_plugin_files();
		$moai_initializer->moai_initialize_hooks();
	}
}

new AI_GPT3_Content_Generator();

<?php
/**
 * This file initializes the plugin.
 *
 * @package ai-gpt3-content-generator\helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class initializes all the required components for the plugin.
 */
class MOAI_Initializer {

	/**
	 * Includes all plugin files.
	 *
	 * @return void
	 */
	public function moai_include_plugin_files() {
		foreach ( glob( MOAI_Utils::moai_get_plugin_dir_path() . 'views' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( MOAI_Utils::moai_get_plugin_dir_path() . 'helper' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( MOAI_Utils::moai_get_plugin_dir_path() . 'helper' . DIRECTORY_SEPARATOR . 'constants' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
		foreach ( glob( MOAI_Utils::moai_get_plugin_dir_path() . 'handler' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
			include_once $filename;
		}
	}

	/**
	 * Enqueues all hooks and filters required by the plugin.
	 *
	 * @return void
	 */
	public function moai_initialize_hooks() {
		add_action( 'admin_menu', array( $this, 'moai_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'moai_enqueue_styles' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'moai_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_init', array( new MOAI_Data_Handler(), 'moai_handle_form_submit' ) );
		add_action( 'wp_ajax_moai_ajax_action', array( new MOAI_Ajax_Handler(), 'moai_handle_ajax' ) );
		add_action( 'add_meta_boxes', array( $this, 'moai_add_meta_box' ) );
	}

	/**
	 * Defines a menu for the plugin.
	 *
	 * @return void
	 */
	public function moai_menu() {
		add_menu_page( 'AI GPT-3 Content Generator', 'AI GPT-3 Content Generator', 'administrator', 'moai_settings', array( new MOAI_View(), 'moai_display_view' ), MOAI_Utils::moai_get_plugin_dir_url() . 'assets/img/miniorange.png' );
	}

	/**
	 * Enqueues all required style files for the plugin.
	 *
	 * @param string $page Contains the value of the page parameter from the URL along with its level and is used to make sure the js is loaded only where it is required.
	 * @return void
	 */
	public function moai_enqueue_styles( $page ) {
		if ( 'post-new.php' === $page || 'post.php' === $page ) {
			wp_enqueue_style( 'moai_metabox_style', plugins_url( 'assets/css/moai_metabox.min.css', dirname( __FILE__ ) ), array(), MOAI_Base_Constants::VERSION, 'all' );
		}

		if ( 'toplevel_page_moai_settings' !== $page ) {
			return;
		}
		wp_enqueue_style( 'moai_style', plugins_url( 'assets/css/moai_style.min.css', dirname( __FILE__ ) ), array(), MOAI_Base_Constants::VERSION, 'all' );
	}

	/**
	 * Enqueues all required js scripts for the plugin.
	 *
	 * @param string $page Contains the value of the page parameter from the URL along with its level and is used to make sure the js is loaded only where it is required.
	 * @return void
	 */
	public function moai_enqueue_scripts( $page ) {

		if ( 'post-new.php' === $page || 'post.php' === $page ) {
			wp_enqueue_script( 'jQuery' );
			wp_enqueue_script( 'moai_metabox_ajax', plugins_url( 'assets/js/moai_metabox_handler.min.js', dirname( __FILE__ ) ), array(), MOAI_Base_Constants::VERSION, true );
			wp_localize_script(
				'moai_metabox_ajax',
				'ajax_object_moai',
				array(
					'ajax_url_moai'   => admin_url( '/admin-ajax.php' ),
					'moai_ajax_nonce' => wp_create_nonce( 'moai_ajax_nonce' ),
				)
			);
		}

		if ( 'toplevel_page_moai_settings' !== $page ) {
			return;
		}
		wp_enqueue_script( 'jQuery' );
		wp_enqueue_script( 'moai_speech_js', plugins_url( 'assets/js/moai_speechrecog.min.js', dirname( __FILE__ ) ), array(), MOAI_Base_Constants::VERSION, true );
		wp_enqueue_script( 'moai_api_ajax', plugins_url( 'assets/js/moai_script.min.js', dirname( __FILE__ ) ), array(), MOAI_Base_Constants::VERSION, true );
		wp_localize_script(
			'moai_api_ajax',
			'ajax_object_moai',
			array(
				'ajax_url_moai'   => admin_url( '/admin-ajax.php' ),
				'moai_ajax_nonce' => wp_create_nonce( 'moai_ajax_nonce' ),
			)
		);
	}

	/**
	 * Adds metabox to all posts and pages.
	 *
	 * @param string|WP_Screen $post_type Screen where the hook was called.
	 * @return void
	 */
	public function moai_add_meta_box( $post_type ) {
		add_meta_box(
			'moai_meta_box',
			'AI Content Generation',
			array( new MOAI_Metabox(), 'moai_metabox_display' ),
			$post_type,
			'side',
			'high'
		);
	}
}

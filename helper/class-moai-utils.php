<?php
/**
 * This file contains all the utility functions of the plugin.
 *
 * @package ai-gpt3-content-generator\helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains all the commonly used functions of the plugin.
 */
class MOAI_Utils {

	/**
	 * Returns the the filesystem directory path of the plugin.
	 *
	 * @return string
	 */
	public static function moai_get_plugin_dir_path() {
		return plugin_dir_path( dirname( __FILE__ ) );
	}

	/**
	 * Returns the URL directory path of the plugin.
	 *
	 * @return string
	 */
	public static function moai_get_plugin_dir_url() {
		return plugin_dir_url( dirname( __FILE__ ) );
	}

	/**
	 * Makes a remote post call and returns result.
	 *
	 * @param string $url URL to get results from.
	 * @param array  $args Array containing request body, headers, timeout, etc.
	 * @return array|mixed
	 */
	public static function moai_wp_remote_post( $url, $args ) {
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			return array();
		} else {
			return json_decode( wp_remote_retrieve_body( $response ), true );
		}
	}

	/**
	 * Makes a remote get call and returns result.
	 *
	 * @param string $url URL to get results from.
	 * @param array  $args Array containing request body, headers, timeout, etc.
	 * @return array|mixed
	 */
	public static function moai_wp_remote_get( $url, $args ) {
		$response      = wp_remote_get( $url, $args );
		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( is_wp_error( $response ) ) {
			return array();
		} elseif ( isset( $response_body['error'] ) ) {
			return array();
		} else {
			return $response_body;
		}
	}

	/**
	 * Returns value stored in db options table.
	 *
	 * @param string $option_name Option name.
	 * @param mixed  $default Optional. Default value to be returned if option is not in db. Default false.
	 * @return mixed
	 */
	public static function moai_get_option( $option_name, $default = false ) {
		return get_site_option( $option_name, $default );
	}

	/**
	 * Saves option value to db.
	 *
	 * @param string $option_name Option name.
	 * @param mixed  $value Option value.
	 * @return void
	 */
	public static function moai_save_option( $option_name, $value ) {
		update_site_option( $option_name, $value );
	}

	/**
	 * Returns plugin configuration stored in db.
	 *
	 * @return array
	 */
	public static function moai_get_plugin_config() {
		return self::moai_get_option( MOAI_Option_Constants::PLUGIN_CONFIG, array() );
	}

}

<?php
/**
 * This file will take care of handling all form submits.
 *
 * @package ai-gpt3-content-generator\handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Form Handler class used to handle all the form submissions in the plugin.
 */
class MOAI_Data_Handler {

	/**
	 * This function is responsible for verifying the nonce and calling the corresponding handlers when a form is submitted.
	 *
	 * @return void
	 */
	public function moai_handle_form_submit() {

		if ( isset( $_POST['option'] ) ) {
			$option = sanitize_text_field( wp_unslash( $_POST['option'] ) );
			check_admin_referer( $option );

			switch ( $option ) {
				case 'moai_settings':
					$this->moai_save_configuration( $_POST );
					break;
			}
		}
	}

	/**
	 * Saves plugin configuration.
	 *
	 * @param array $post_data Contains data of plugin configuration form.
	 * @return void
	 */
	private function moai_save_configuration( $post_data ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have permission to view this page' );
		}

		if ( ! isset( $post_data['api_key'] ) || empty( $post_data['api_key'] ) ) {
			wp_die( 'API Key is required!' );
		}

		$plugin_config = array(
			'api_key'          => $post_data['api_key'],
			'engine'           => $post_data['engine'],
			'default_language' => $post_data['default_language'],
		);

		MOAI_Utils::moai_save_option( MOAI_Option_Constants::PLUGIN_CONFIG, $plugin_config );
	}


}

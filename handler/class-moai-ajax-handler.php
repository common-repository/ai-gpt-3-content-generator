<?php
/**
 * This file will take care of all Ajax requests.
 *
 * @package ai-gpt3-content-generator\handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class will handle all Ajax requests in the plugin.
 */
class MOAI_Ajax_Handler {

	/**
	 * Receives all ajax requests and redirects them to appropriate handlers.
	 *
	 * @return void
	 */
	public function moai_handle_ajax() {

		if ( check_ajax_referer( 'moai_ajax_nonce' ) && isset( $_POST['action-type'] ) && isset( $_POST['query'] ) ) {
			$query = sanitize_text_field( wp_unslash( $_POST['query'] ) );
			switch ( $_POST['action-type'] ) {
				case 'answer_query':
					$gpt_api = new MOAI_API();
					$replies = isset( $_POST['replies'] ) ? 1 : 3;

					$response = $gpt_api->moai_text_completion( $query, $replies );
					if ( empty( $response ) ) {
						wp_send_json_success( 'Something went Wrong cant connect to API', 500 );
					} else {
						if ( isset( $response['choices'] ) ) {
							wp_send_json_success( $response['choices'], 200 );
						} else {
							wp_send_json_success( 'Did not get response from API', 500 );
						}
					}
					break;

				case 'generate_image':
					$gpt_api = new MOAI_API();

					$generate_multiple = isset( $_POST['generate_multiple'] );

					$response = $gpt_api->moai_get_image_from_dalle( $query, $generate_multiple );
					if ( empty( $response ) ) {
						wp_send_json_success( 'Something went Wrong cant connect to API', 500 );
					} else {
						if ( isset( $response['data'][0] ) ) {
							if ( ! $generate_multiple ) {
								wp_send_json_success( $response['data'][0]['url'], 200 );
							} else {
								wp_send_json_success( $response['data'], 200 );
							}
						} else {
							wp_send_json_success( 'Did not get response from API', 500 );
						}
					}
					break;

				case 'save_image':
					$image_url   = isset( $_POST['image_url'] ) ? esc_url_raw( wp_unslash( $_POST['image_url'] ) ) : '';
					$image_title = isset( $_POST['image_title'] ) ? sanitize_text_field( wp_unslash( $_POST['image_title'] ) ) : '';

					if ( empty( $image_url ) || empty( $image_title ) ) {
						wp_send_json_success( 'Image URL or title missing!', 400 );
					}

					$image_processing = new MOAI_Image_Processing();
					$result           = $image_processing->moai_save_image_media( $image_url, $image_title );

					$response = array(
						'message' => 'Image Saved to media library!',
					);

					if ( ! $result ) {
						$response['message'] = 'Something went wrong.';
						wp_send_json_success( $response, 500 );
					}
					$response = array_merge( $response, $result );
					wp_send_json_success( $response, 200 );
					break;
			}
		}
	}
}

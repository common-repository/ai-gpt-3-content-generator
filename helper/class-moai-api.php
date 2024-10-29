<?php
/**
 * This file contains functions to query various OpenAI Endpoints.
 *
 * @package ai-gpt3-content-generator\helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class contains functions to query various OpenAI Endpoints.
 */
class MOAI_API {

	/**
	 * Stores the plugin configuration.
	 *
	 * @var array
	 */
	private $plugin_config;

	/**
	 * Text completion engine to be used.
	 *
	 * @var string
	 */
	private $engine;

	/**
	 * API Key for OpenAI.
	 *
	 * @var string
	 */
	private $api_key;

	/**
	 * Default language for response.
	 *
	 * @var string
	 */
	private $default_language;

	/**
	 * Initializes all required class variables.
	 *
	 * @param array $plugin_config Optional. Plugin configuration array. Default empty.
	 */
	public function __construct( $plugin_config = array() ) {
		if ( empty( $plugin_config ) ) {
			$plugin_config = MOAI_Utils::moai_get_plugin_config();
		}
		$this->plugin_config    = $plugin_config;
		$this->engine           = $plugin_config['engine'];
		$this->api_key          = $plugin_config['api_key'];
		$this->default_language = $plugin_config['default_language'];
	}

	/**
	 * Sends query to the default configured text completion engine.
	 *
	 * @param string $query Query to be sent.
	 * @param int    $replies How many replies are to be returned.
	 * @return array|mixed
	 */
	public function moai_text_completion( $query, $replies ) {

		$query  = ' Please respond in ' . $this->default_language . '. ' . $query;
		$method = 'POST';
		$data   = wp_json_encode(
			array(
				'model'       => $this->engine,
				'prompt'      => $query,
				'max_tokens'  => MOAI_Base_Constants::MODEL_TOKENS[ $this->engine ],
				'temperature' => 0.5,
				'n'           => $replies,
			)
		);

		$headers = $this->moai_generate_api_headers();

		$args = array(
			'method'  => $method,
			'body'    => $data,
			'headers' => $headers,
			'timeout' => 500,
		);
		return MOAI_Utils::moai_wp_remote_post( MOAI_API_Endpoint_Constants::TEXT_COMPLETION_ENDPOINT, $args );
	}

	/**
	 * Queries DallE model by OpenAI for image.
	 *
	 * @param string  $query Image description.
	 * @param boolean $generate_multiple Whether to generate multiple images or not.
	 * @return array|mixed
	 */
	public function moai_get_image_from_dalle( $query, $generate_multiple ) {

		$method = 'POST';

		$n = ( $generate_multiple ) ? 3 : 1;

		$data = wp_json_encode(
			array(
				'prompt' => $query,
				'n'      => $n,
				'size'   => '512x512',
			)
		);

		$headers = $this->moai_generate_api_headers();

		$args = array(
			'method'  => $method,
			'body'    => $data,
			'headers' => $headers,
			'timeout' => 500,
		);
		return MOAI_Utils::moai_wp_remote_post( MOAI_API_Endpoint_Constants::IMAGE_GENERATION_ENDPOINT, $args );
	}

	/**
	 * Returns authentication headers for OpenAI api calls.
	 *
	 * @return array.
	 */
	private function moai_generate_api_headers() {
		return array(
			'Authorization' => 'Bearer ' . $this->api_key,
			'Content-Type'  => 'application/json',
		);
	}

	/**
	 * Returns a list of all models available for text completion.
	 *
	 * @return array
	 */
	public function moai_get_all_text_models() {
		$method = 'GET';

		$headers = $this->moai_generate_api_headers();

		$args = array(
			'method'  => $method,
			'headers' => $headers,
			'timeout' => 500,
		);
		return MOAI_Utils::moai_wp_remote_get( MOAI_API_Endpoint_Constants::MODEL_LIST_ENDPOINT, $args );
	}

}

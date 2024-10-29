<?php
/**
 * This file will contain all constants required for plugin operations.
 *
 * @package ai-gpt3-content-generator\helper\constants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class contains all constants required for plugin operations.
 */
class MOAI_Base_Constants {
	const HOSTNAME = 'https://login.xecurify.com';
	const VERSION  = '1.0.0';

	const SUPPORTED_MODELS = array(
		'text-davinci-003',
		'text-curie-001',
		'text-babbage-001',
		'text-ada-001',
	);

	const MODEL_TOKENS = array(
		'text-davinci-003' => 3000,
		'text-curie-001'   => 1500,
		'text-babbage-001' => 1500,
		'text-ada-001'     => 1500,
	);

	const SUPPORTED_LANGUAGES = array(
		'English',
		'Arabic',
		'Bulgarian',
		'Chinese',
		'Croatian',
		'Czech',
		'Danish',
		'Dutch',
		'Estonian',
		'Filipino',
		'Finnish',
		'French',
		'German',
		'Greek',
		'Hebrew',
		'Hindi',
		'Hungarian',
		'Indonesian',
		'Italian',
		'Japanese',
		'Korean',
		'Latvian',
		'Lithuanian',
		'Malay',
		'Norwegian',
		'Polish',
		'Portuguese',
		'Romanian',
		'Russian',
		'Serbian',
		'Slovak',
		'Slovenian',
		'Spanish',
		'Swedish',
		'Thai',
		'Turkish',
		'Ukrainian',
		'Vietnamese',
	);
}

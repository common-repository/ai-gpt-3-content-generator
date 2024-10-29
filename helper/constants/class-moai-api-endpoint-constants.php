<?php
/**
 * This file contains all constants related to API endpoints.
 *
 * @package ai-gpt3-content-generator\helper\constants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains all constants for API Endpoints.
 */
class MOAI_API_Endpoint_Constants {
	const API_KEY                   = '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';
	const IMAGE_GENERATION_ENDPOINT = 'https://api.openai.com/v1/images/generations';
	const MODEL_LIST_ENDPOINT       = 'https://api.openai.com/v1/models';
	const TEXT_COMPLETION_ENDPOINT  = 'https://api.openai.com/v1/completions';
}

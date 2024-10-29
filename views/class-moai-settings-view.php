<?php
/**
 * This file will take care of displaying the configure settings page.
 *
 * @package ai-gpt3-content-generator\views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Takes care of displaying the configure settings page.
 */
class MOAI_Settings_View {
	/**
	 * Displays the configure settings page.
	 *
	 * @return void
	 */
	public function moai_settings() {
		$moai_config_array   = MOAI_Utils::moai_get_plugin_config();
		$api_key             = isset( $moai_config_array['api_key'] ) ? $moai_config_array['api_key'] : '';
		$default_language    = isset( $moai_config_array['default_language'] ) ? $moai_config_array['default_language'] : 'English';
		$selected_engine     = isset( $moai_config_array['engine'] ) ? $moai_config_array['engine'] : 'text-davinci-003';
		$engines             = MOAI_Base_Constants::SUPPORTED_MODELS;
		$available_languages = MOAI_Base_Constants::SUPPORTED_LANGUAGES;

		?>
			<div class="moai-settings-container">
				<form action="" method="post">
					<?php wp_nonce_field( 'moai_settings' ); ?>
					<input type="hidden" name="option" value="moai_settings" />
					<div class="moai-row">
						<div class="moai-mw-10vw">API Key<span class="moai-required">*</span></div>
						<div class="moai-mw-15vw">
							<input type="text" name="api_key" id="api_key" required placeholder="Enter your API key here." value="<?php echo esc_attr( $api_key ); ?>" />
						</div>
						<div class="moai-settings-info">
							You can find your API Key here: <a href="https://platform.openai.com/account/api-keys" target='_blank'>Link</a>
						</div>
					</div>
					<div class="moai-row">
						<div class="moai-mw-10vw">AI Engine</div>
						<div class="moai-mw-15vw">
							<select name="engine" id="engine" onchange="moai_show_model_desc()">
							<?php
							foreach ( $engines as $engine ) {
								$selected = ( $engine === $selected_engine ) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr( $engine ); ?>" <?php echo esc_html( $selected ); ?>><?php echo esc_html( $engine ); ?></option>
								<?php
							}
							?>
							</select>
						</div>
						<div class="moai-settings-info">
							<div class="moai-model-info" id="text-davinci-003-info">Davinci is the <b>most capable</b> model, it is able to solve logic problems, determine cause and effect, understand the intent of text, produce creative content, explain character motives, and handle complex summarization tasks.</div>
							<div class="moai-model-info" id="text-curie-001-info">Curie tries to <b>balance power and speed</b>. It can do anything that Ada or Babbage can do but it's also capable of handling more complex classification tasks and more nuanced tasks like <b>summarization, sentiment analysis, chatbot applications, and Question and Answers.</b></div>
							<div class="moai-model-info" id="text-babbage-001-info">Babbage is a <b>bit more capable than Ada</b> but not quite as performant. It can perform all the same tasks as Ada, but it can also handle a bit more involved classification tasks, and it's <b>well suited for semantic search tasks</b> that rank how well documents match a search query.</div>
							<div class="moai-model-info" id="text-ada-001-info">Ada is usually the <b>fastest model and least costly</b>. It's best for less nuanced tasks—for example, <b>parsing text, reformatting text, and simpler classification tasks</b>. The more context you provide Ada, the better it will likely perform.</div>
						</div>
					</div>
					<div class="moai-row">
						<div class="moai-mw-10vw">Default Language</div>
						<div class="moai-mw-15vw">
							<select name="default_language" id="default_language">
							<?php
							foreach ( $available_languages as $language ) {
								$selected = ( $language === $default_language ) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr( $language ); ?>" <?php echo esc_html( $selected ); ?> ><?php echo esc_html( $language ); ?></option>
								<?php
							}
							?>
							</select>
						</div>
						<div class="moai-settings-info">
							This will be the default response language for the AI. 
						</div>
					</div>
					<div class="moai-row">
						<input type="submit" class="button-primary" value="Save Configuration"/>
					</div>
				</form>
			</div>
		<?php
	}
}

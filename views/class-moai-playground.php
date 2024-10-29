<?php
/**
 * This file takes care of displaying both the text and image playground.
 *
 * @package ai-gpt3-content-generator\views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class contains functions to display both text and image playgrounds.
 */
class MOAI_Playground {
	/**
	 * Displays the text playground.
	 *
	 * @return void
	 */
	public function moai_display_text_playground() {
		$available_languages = MOAI_Base_Constants::SUPPORTED_LANGUAGES;
		?>
			<div class="moai-text-playground-container">
				<div class="moai-prompt-selector">
					<div class="moai-prompt-selector-btn" id="content_writer" onclick="moai_change_playground(event);">Content Writer</div>
					<div class="moai-prompt-selector-btn" id="proofreader" onclick="moai_change_playground(event);">Proofread</div>
					<div class="moai-prompt-selector-btn" id="summary" onclick="moai_change_playground(event);">Summaries and Excerpts</div>
					<div class="moai-prompt-selector-btn" id="translate" onclick="moai_change_playground(event);">Translate Articles</div>
					<div class="moai-prompt-selector-btn" id="seo" onclick="moai_change_playground(event);">SEO</div>
					<div class="moai-prompt-selector-btn" id="wp_assistant" onclick="moai_change_playground(event);">WordPress Assistant</div>
					<div class="moai-prompt-selector-btn" id="playground" onclick="moai_change_playground(event);">AI Playground</div>
				</div>
				<div class="moai-prompt-container">
					<div class="moai-input-controls">
						<h2 id="moai-playground-title">Enter parameters for the blog</h2>
						<div class="moai-playground-input-div" id="playground-input-blog-topic">
							<div class="moai-mw-10vw moai-playground-input-label">
								Topic of the Blog:
							</div>
							<div class="moai-mw-15vw">
								<input type="text" class="moai-playground-input" placeholder="Enter your blog topic here." name="input-blog-topic" id="input-blog-topic"/>
							</div>
						</div>
						<div class="moai-playground-input-div" id="playground-input-word-count">
							<div class="moai-mw-10vw moai-playground-input-label">
								Words in the blog:
							</div>
							<div class="moai-mw-15vw">
								<input type="number" class="moai-playground-input" value="500" name="input-word-count" id="input-word-count"/>
							</div>
						</div>
						<div class="moai-playground-input-div" id="playground-input-translate-language">
							<div class="moai-mw-10vw moai-playground-input-label">
								Language:
							</div>
							<div class="moai-mw-15vw">
								<select class="moai-playground-input" name="translate-language" id="input-translate-language">
								<?php
								foreach ( $available_languages as $language ) {
									?>
										<option value="<?php echo esc_attr( $language ); ?>" ><?php echo esc_html( $language ); ?></option>
									<?php
								}
								?>
								</select>
							</div>
						</div>
						<div class="moai-playground-input-div" id="playground-input-blog-content">
							<div class="moai-playground-input-label">
								Enter your content:
							</div>
							<div>
								<textarea class="moai-content-input-textarea moai-playground-input" name="input-blog-content" id="input-blog-content" placeholder="Enter your content here"></textarea>
							</div>
						</div>
						<div class="moai-playground-input-div" id="playground-input-resultbox">
							<h2 id="moai-playground-result-title">Content generated</h2>
							<textarea class="moai-prompt-textarea" name="input-resultbox" id="input-resultbox"></textarea>
							<button id="moai-copy-to-clipboard-btn" class="moai-long-btn button-primary" onclick="moai_copy_text_to_clipboard('input-resultbox');">Copy Content to Clipboard</button>
							<button id="moai-reset-playground-btn" name="content_writer" class="moai-reset-pg-btn moai-long-btn button-primary" onclick="moai_reset_playground(event)">Reset / Start Over</button>
						</div>
					</div>
					<div class="moai-query-box">
						<div class="moai-query-container">
							<input type="text" class="moai-query-input" placeholder="Enter your query here" name="querybox" id="querybox" onkeypress="moai_enter_save();">
							<img src="<?php echo esc_url( MOAI_Utils::moai_get_plugin_dir_url() ); ?>assets/img/mic.gif" class="moai-mic-img" onclick="moai_start_button();"> </img>
						</div>
						<button id="sendbtn" class="moai-query-submit-btn moai-long-btn button-primary" onclick="moai_process_query();">Submit Query</button>
					</div>
					<div id="moai-preloader" style="display: none;text-align:center">
						<br>
						<img width="60%" src="<?php echo esc_url( MOAI_Utils::moai_get_plugin_dir_url() ); ?>assets/img/preloader.gif" alt="Loading....">
						<br>
						<h1 id="moai-preloader-text">AI is working on your Query</h1>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * Displays the image playground.
	 * Note: Nonce for these forms are added through js, nonce is generated when the js enqueued, and is passed when the form submits through js.
	 * 
	 * @return void
	 */
	public function moai_display_image_playground() {
		?>
			<div class="moai-image-playground">
				<form>
					<h3>Image Generation</h3>
					<label for="qbox">Describe Image:</label><br>
					<textarea style="width: 78vw; margin-bottom:10px" id="qbox" rows="2" placeholder="Describe your image here"></textarea>
					<button type="button" id="sendbtn" style="width: 78vw; height: 6vh;" class="button-primary" onclick="moai_process_img_query();">Get Image</button>
					<br><br>
					<label class="statuslabel" hidden id="status" value="Processing">AI is Generating your image</label><br>
				</form>
				<br>
				<h3 id="moai-image-title"></h3>
				<div class="moai-image-playground-options">
					<div id="placeholderimg"></div>
					<div class="moai-image-options">
						<h1>Image Options</h1>
						<hr><br>
						<form action="#">
							<input type="text" name="image_title" id="image_title" placeholder="Enter Image Title" required/><br><br>
							<button type="button" class="button-secondary" onclick="moai_save_to_media_library();">Save to Media Library</button>
						</form>						
						<h2 id="image_save_status" style="color:green"></h2>
						<div id="after_image_saved" style="display:none">
							<a id="view_image_attachment" href="" target="_blank"><button class="button-primary">View Attachment</button></a>
						</div>
					</div>
				</div>
			</div>
		<?php
	}

}

<?php
/**
 * This file takes care of rending metabox for post.
 *
 * @package ai-gpt3-content-generator\views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class takes care of rending metabox for post.
 */
class MOAI_Metabox {

	/**
	 * Renders metabox for post.
	 *
	 * @param WP_POST $post Post Object.
	 * @return void
	 */
	public function moai_metabox_display( $post ) {

		wp_nonce_field( 'moai_inner_custom_box', 'moai_inner_custom_box_nonce' );

		$post_type = $post->post_type;

		?>
		<div class="row">
			<img src="<?php echo esc_url( MOAI_Utils::moai_get_plugin_dir_url() ); ?>assets/img/miniorange-logo.png" alt="miniOrange AI Content Generation" width="35px">
			<h4 style="position:absolute;top:-0.6rem;left:4.2rem;">AI Content Generation</h4>
		</div>
		<input type="button" class="moai-metabox-btn button" id="moai_metabox_generate_title" name="moai_metabox_generate_title" value="Generate Title" onclick="moai_generate_title()"/>
		</br>
		<input type="button" class="moai-metabox-btn button" id="moai_metabox_generate_content" name="moai_metabox_generate_content" value="Generate Content based on title" onclick="moai_generate_content()"/>
		<?php if ( 'page' !== $post_type ) { ?>
			</br>
			<input type="button" class="moai-metabox-btn button" id="moai_metabox_generate_excerpt" name="moai_metabox_generate_excerpt" value="Generate Excerpt for this post" onclick="moai_generate_excerpt()"/>
		<?php } ?>
		</br>
		<input type="button" class="moai-metabox-btn button" id="moai_metabox_generate_featured_image" name="moai_metabox_generate_featured_image" value="Generate Featured Image" onclick="moai_generate_featured_image()"/>
		<div id="moai-modal" class="moai-modal">
			<div class="moai-modal-preloader">
				<h2 style="font-weight:600;font-size:large;">Saving the featured image please wait.</h2>
			</div>
			<div class="moai-modal-content">
				<span id="moai-close-modal" class="moai-close">&times;</span>
				<div id="moai-modal-container">
					<div class="moai-title" style="display:flex">
						<div>
							<h1 id="moai-modal-title">Modal title</h1>
						</div>
					</div>
					<div id="moai-select-info-text" style="display: none;">
						<p style="color: #0b96cf;">Please click on a tile to select it.</p>
					</div>
					<hr style="margin: 0em 0 1.9em 0;">
					<div id="moai-modal-results">
						<div id="moai-preloader" style="display: none;text-align:center">
							<img width="60%" src="<?php echo esc_url( MOAI_Utils::moai_get_plugin_dir_url() ); ?>assets/img/preloader.gif" alt="Loading....">
							<br>
							<h1 id="moai-preloader-text">AI is working on your request</h1>
						</div>
						<div id="moai-modal-suggestions"></div>
					</div>
					<div class="moai-modal-title-input" id="moai-modal-title-input">
						<input type="text" name="new_title" id="new_title" style="width: 89%;box-shadow: inset 1px 1px 3px #a7a7af;height: 34px;" placeholder="What do you want to write about?"/>
						<input type="button" class="moai-title-submit-btn" onclick="moai_user_inputs_title()" value="Submit">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}

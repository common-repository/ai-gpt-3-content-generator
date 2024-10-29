<?php
/**
 * This file takes care of displaying the views for the plugin.
 *
 * @package ai-gpt3-content-generator\views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the view layer in plugin.
 */
class MOAI_View {

	/**
	 * Displays the plugin header and tab list, calls the tab content display function.
	 *
	 * @return void
	 */
	public function moai_display_view() {
		$active_tab = 'moai_settings';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading tab name from URL.
		if ( isset( $_GET['tab'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading tab name from URL.
			$active_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}

		?>
			<div class="moai-main-container">
				<input type="text" hidden id="moai-plugin-path" value="<?php echo esc_url_raw( MOAI_Utils::moai_get_plugin_dir_url() ); ?>">
				<?php
					$this->moai_header();
					$this->moai_tab_list( $active_tab );
				?>
				<div class="moai-body">
					<?php
						$this->moai_show_tab( $active_tab );
					?>
				</div>
			</div>
		<?php
	}

	/**
	 * Displays the plugin header
	 *
	 * @return void
	 */
	private function moai_header() {
		?>
			<div class="moai-header">
				<h1>WordPress Content Generation</h1>
			</div>
			<div class="moai-message moai-message-success" style="display:none;"></div>
		<?php
	}

	/**
	 * Displays the plugin tab list.
	 *
	 * @param string $active_tab Name of the current active tab.
	 * @return void
	 */
	private function moai_tab_list( $active_tab ) {
		$url = '';
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$url = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
		}
		?>
			<div class="moai-tab-list">
				<a class="moai-nav-tab-cstm <?php echo esc_html( 'moai_settings' === $active_tab ? 'moai-nav-tab-active' : '' ); ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'moai_settings' ), $url ) ); ?>">Plugin Settings</a>
				<a class="moai-nav-tab-cstm <?php echo esc_html( 'moai_playground' === $active_tab ? 'moai-nav-tab-active' : '' ); ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'moai_playground' ), $url ) ); ?>">Text Playground</a>
				<a class="moai-nav-tab-cstm <?php echo esc_html( 'moai_image_playground' === $active_tab ? 'moai-nav-tab-active' : '' ); ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'moai_image_playground' ), $url ) ); ?>">Image Playground</a>
			</div>
		<?php
	}

	/**
	 * Displays content for tabs.
	 *
	 * @param string $active_tab Name of the current active tab.
	 * @return void
	 */
	private function moai_show_tab( $active_tab ) {
		?>
			<div class="moai-tab">
				<?php
				switch ( $active_tab ) {
					case 'moai_settings':
						$moai_settings = new MOAI_Settings_View();
						$moai_settings->moai_settings();
						break;
					case 'moai_playground':
						$moai_playground = new MOAI_Playground();
						$moai_playground->moai_display_text_playground();
						break;
					case 'moai_image_playground':
						$moai_playground = new MOAI_Playground();
						$moai_playground->moai_display_image_playground();
						break;
				}
				?>
			</div>
		<?php
	}

}

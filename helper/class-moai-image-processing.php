<?php
/**
 * This file takes care of image operations.
 *
 * @package ai-gpt3-content-generator\helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class will take care of all image processing operations.
 */
class MOAI_Image_Processing {

	/**
	 * This function downloads an image and saves it to the media library as an attachment.
	 *
	 * @param string $image_url Image URL.
	 * @param string $image_title Image Title.
	 * @return boolean
	 */
	public function moai_save_image_media( $image_url, $image_title ) {

		$image_attachment_id = $this->moai_save_image( $image_url, $image_title );
		if ( $image_attachment_id ) {
			wp_update_post(
				array(
					'ID'           => $image_attachment_id,
					'post_content' => $image_title,
					'post_excerpt' => $image_title,
				)
			);
			update_post_meta( $image_attachment_id, '_wp_attachment_image_alt', $image_title );
		} else {
			return false;
		}
		$response = array(
			'attachment_url' => wp_get_attachment_url( $image_attachment_id ),
			'attachment_id'  => $image_attachment_id,
		);
		return $response;
	}

	/**
	 * This function will download the image from remote server and save it.
	 *
	 * @param string $image_url Image URL.
	 * @param string $image_title Image Title.
	 * @return int|boolean Attachment ID if we create attachment, false for failure.
	 */
	public function moai_save_image( $image_url, $image_title ) {
		$result = false;
		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			include_once ABSPATH . 'wp-admin/includes/image.php';
		}
		if ( ! function_exists( 'download_url' ) ) {
			include_once ABSPATH . 'wp-admin/includes/file.php';
		}
		if ( ! function_exists( 'media_handle_sideload' ) ) {
			include_once ABSPATH . 'wp-admin/includes/media.php';
		}
		try {
			$array     = explode( '/', getimagesize( $image_url )['mime'] );
			$imagetype = end( $array );
			$uniq_name = md5( $image_url );
			$filename  = $uniq_name . '.' . $imagetype;
			$tmp       = download_url( $image_url );
			if ( is_wp_error( $tmp ) ) {
				return false;
			}
			$args          = array(
				'name'     => $filename,
				'tmp_name' => $tmp,
			);
			$attachment_id = media_handle_sideload(
				$args,
				0,
				'',
				array(
					'post_title'   => $image_title,
					'post_content' => $image_title,
					'post_excerpt' => $image_title,
				)
			);
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $image_title );
			if ( ! is_wp_error( $attachment_id ) ) {
				$image_new      = get_post( $attachment_id );
				$full_size_path = get_attached_file( $image_new->ID );
				$attach_data    = wp_generate_attachment_metadata( $attachment_id, $full_size_path );
				wp_update_attachment_metadata( $attachment_id, $attach_data );
				$result = $attachment_id;
			}
		} catch ( \Exception $exception ) {
			return false;
		}
		return $result;
	}
}

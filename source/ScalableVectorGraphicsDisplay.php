<?php

namespace Cyberhobo\MediaLibrary;

use add_action;
use add_filter;
use wp_add_inline_style;
use simplexml_load_file;

class ScalableVectorGraphicsDisplay {

	public function enable() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_administration_styles' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'adjust_response_for_svg' ), 10, 3 );
	}

	public function add_administration_styles() {
		$this->add_media_listing_style();
		$this->add_featured_image_style();	
	}

	public function adjust_response_for_svg( $response, $attachment, $meta ) {
		if ( 'image/svg+xml' != $response['mime'] or ! empty( $response['sizes'] ) ) {
			return $response;
		}

		$dimensions = $this->get_dimensions( get_attached_file( $attachment->ID ) );

		$response['sizes'] = array(
			'full' => array(
				'url' => $response['url'],
				'width' => $dimensions->width,
				'height' => $dimensions->height,
				'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait',
			)
		);
		
		return $response;
	}

	protected function add_media_listing_style() {
		wp_add_inline_style( 'wp-admin', ".media .media-icon img[src$='.svg'] { width: auto; height: auto; }" );
	}

	protected function add_featured_image_style() {
		wp_add_inline_style( 'wp-admin', "#postimagediv .inside img[src$='.svg'] { width: 100%; height: auto; }" );
	}

	protected function get_dimensions( $svg_path ) {
		$svg = simplexml_load_file( $svg );
		$attributes = $svg->attributes();
		$width = (string) $attributes->width;
		$height = (string) $attributes->height;

		return (object) compact( 'width', 'height' );
	}
}

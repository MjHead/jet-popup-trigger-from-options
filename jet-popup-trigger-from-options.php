<?php
/**
 * Plugin Name: JetPopup - control popup from options page
 * Plugin URI:  #
 * Description: Allow to enable/disable popup visibility from JetEngine option page
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'wp_footer', 'jet_ptfo_init', 2 );

function jet_ptfo_init() {

	if ( ! function_exists( 'jet_engine' ) || ! function_exists( 'jet_popup' ) ) {
		return;
	}

	$config = apply_filters( 'jet-ptfo/config', array() );

	if ( empty( $config ) ) {
		return;
	}

	foreach ( $config as $item ) {
		
		$page = ! empty( $item['page'] ) ? $item['page'] : false;
		$option = ! empty( $item['option'] ) ? $item['option'] : false;
		$popup = ! empty( $item['popup'] ) ? $item['popup'] : false;

		if ( ! $page || ! $option || ! $popup ) {
			continue;
		}

		$value = jet_engine()->listings->data->get_option( $page . '::' . $option );
		$enabled = false;

		if ( ! is_array( $value ) ) {
			$enabled = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		} else {
			if ( empty( $value ) ) {
				$enabled = false;
			} else {
				$value = array_values( $value );
				$value = $value[0];

				if ( ! in_array( $value, array( 'true', 'false' ) ) ) {
					$enabled = true;
				} else {
					$enabled = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
				}

			}
		}

		if ( $enabled ) {
			if ( $popup != jet_popup()->conditions_manager->find_matched_popups_by_conditions() ) {
				continue;
			}
			jet_popup()->generator->popup_id_list[] = $popup;
		} else {
			$popups = jet_popup()->generator->defined_popup_list;
			
			foreach( $popups as $key => $data ) {
				if ( $data['id'] !== $popup ) {
					continue;
				} else {
					unset(jet_popup()->generator->defined_popup_list[ $key ]);
				}
			}

		}

	}

}

/**
 * Config example
 */
add_filter( 'jet-ptfo/config', function( $config ) {

	$config[] = array(
		'page' => 'color-options',
		'option' => 'enable-popup',
		'popup' => 762,
	);

	return $config;
} );

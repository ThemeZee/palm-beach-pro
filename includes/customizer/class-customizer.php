<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Palm Beach Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Customizer Class
 */
class Palm_Beach_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Palm Beach Theme is not active.
		if ( ! current_theme_supports( 'palm-beach-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'palm_beach_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		$theme_options = wp_parse_args( get_option( 'palm_beach_theme_options', array() ), self::get_default_options() );

		// Return theme options.
		return $theme_options;

	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'logo_spacing'						=> 10,
			'navi_spacing'						=> 10,
			'footer_text'						=> '',
			'credit_link' 						=> true,
			'top_navi_color'					=> '#4477aa',
			'header_color'						=> '#111133',
			'content_primary_color'				=> '#111133',
			'content_secondary_color'			=> '#4477aa',
			'footer_widgets_color'				=> '#111133',
			'footer_color'						=> '#111133',
			'text_font' 						=> 'Hind',
			'title_font' 						=> 'Montserrat',
			'navi_font' 						=> 'Hind',
			'available_fonts'					=> 'favorites',
		);

		return $default_options;

	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {

		wp_enqueue_script( 'palm-beach-pro-customizer-js', PALM_BEACH_PRO_PLUGIN_URL . 'assets/js/customizer.js', array( 'customize-preview' ), PALM_BEACH_PRO_VERSION, true );

	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {

		wp_enqueue_style( 'palm-beach-pro-customizer-css', PALM_BEACH_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), PALM_BEACH_PRO_VERSION );

	}
}

// Run Class.
add_action( 'init', array( 'Palm_Beach_Pro_Customizer', 'setup' ) );

<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Palm Beach Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		return wp_parse_args( get_option( 'palm_beach_theme_options', array() ), self::get_default_options() );
	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'logo_spacing'              => 10,
			'navi_spacing'              => 10,
			'scroll_to_top'             => false,
			'footer_text'               => '',
			'credit_link'               => true,
			'primary_color'             => '#57b7d7',
			'secondary_color'           => '#3e9ebe',
			'tertiary_color'            => '#2484a4',
			'accent_color'              => '#57d777',
			'highlight_color'           => '#d75f57',
			'light_gray_color'          => '#e4e4e4',
			'gray_color'                => '#646464',
			'dark_gray_color'           => '#242424',
			'top_navi_color'            => '#242424',
			'header_color'              => '#ffffff',
			'link_color'                => '#57b7d7',
			'title_color'               => '#242424',
			'footer_widgets_color'      => '#242424',
			'footer_color'              => '#ffffff',
			'text_font'                 => 'Hind',
			'title_font'                => 'Montserrat',
			'title_is_bold'             => true,
			'title_is_uppercase'        => true,
			'navi_font'                 => 'Hind',
			'navi_is_bold'              => false,
			'navi_is_uppercase'         => false,
			'widget_title_font'         => 'Rambla',
			'widget_title_is_bold'      => true,
			'widget_title_is_uppercase' => true,
		);

		return $default_options;
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'palm-beach-pro-customizer-js', PALM_BEACH_PRO_PLUGIN_URL . 'assets/js/customize-preview.js', array( 'customize-preview' ), '20210215', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'palm-beach-pro-customizer-css', PALM_BEACH_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), '20210212' );
	}
}

// Run Class.
add_action( 'init', array( 'Palm_Beach_Pro_Customizer', 'setup' ) );

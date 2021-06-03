<?php
/**
 * Scroll to Top
 *
 * Displays scroll to top button based on theme options
 *
 * @package Palm Beach Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scroll to Top Class
 */
class Palm_Beach_Pro_Scroll_To_Top {

	/**
	 * Scroll to Top Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Palm Beach Theme is not active.
		if ( ! current_theme_supports( 'palm-beach-pro' ) ) {
			return;
		}

		// Enqueue Scroll-To-Top JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );

		// Add Scroll-To-Top Checkbox in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'scroll_to_top_settings' ) );
	}

	/**
	 * Enqueue Scroll-To-Top JavaScript
	 *
	 * @return void
	 */
	static function enqueue_script() {

		// Get Theme Options from Database.
		$theme_options = Palm_Beach_Pro_Customizer::get_theme_options();

		// Call Credit Link function of theme if credit link is activated.
		if ( true === $theme_options['scroll_to_top'] && ! self::is_amp() ) :

			wp_enqueue_script( 'palm-beach-pro-scroll-to-top', PALM_BEACH_PRO_PLUGIN_URL . 'assets/js/scroll-to-top.min.js', array( 'jquery' ), '20210603', true );

			// Passing Parameters to navigation.js.
			wp_localize_script( 'palm-beach-pro-scroll-to-top', 'palmBeachProScrollToTop', array( 'icon' => self::get_svg( 'collapse' ) ) );

		endif;
	}

	/**
	 * Get SVG icon.
	 *
	 * @return void
	 */
	static function get_svg( $icon ) {
		if ( function_exists( 'palm_beach_get_svg' ) ) {
			return palm_beach_get_svg( $icon );
		}
	}

	/**
	 * Add scroll to top checkbox setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function scroll_to_top_settings( $wp_customize ) {

		// Add Scroll to Top headline.
		$wp_customize->add_control( new Palm_Beach_Customize_Header_Control(
			$wp_customize, 'palm_beach_theme_options[scroll_top_title]', array(
				'label'    => esc_html__( 'Scroll to Top', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_footer',
				'settings' => array(),
				'priority' => 10,
			)
		) );

		// Add Scroll to Top setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[scroll_to_top]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'palm_beach_theme_options[scroll_to_top]', array(
			'label'    => __( 'Display Scroll to Top Button', 'palm-beach-pro' ),
			'section'  => 'palm_beach_pro_section_footer',
			'settings' => 'palm_beach_theme_options[scroll_to_top]',
			'type'     => 'checkbox',
			'priority' => 20,
		) );
	}

	/**
	 * Checks if AMP page is rendered.
	 */
	static function is_amp() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}
}

// Run Class.
add_action( 'init', array( 'Palm_Beach_Pro_Scroll_To_Top', 'setup' ) );

<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Palm Beach Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Colors Class
 */
class Palm_Beach_Pro_Custom_Colors {

	/**
	 * Custom Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Palm Beach Theme is not active.
		if ( ! current_theme_supports( 'palm-beach-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'palm_beach_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );
	}

	/**
	 * Adds Color CSS styles in the head area to override default colors
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = Palm_Beach_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Palm_Beach_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Set Link Color.
		if ( $theme_options['link_color'] != $default_options['link_color'] ) {
			$color_variables .= '--link-color: ' . $theme_options['link_color'] . ';';
			$color_variables .= '--button-hover-color: ' . $theme_options['link_color'] . ';';
			$color_variables .= '--site-title-hover-color: ' . $theme_options['link_color'] . ';';
			$color_variables .= '--title-hover-color: ' . $theme_options['link_color'] . ';';
			$color_variables .= '--widget-title-hover-color: ' . $theme_options['link_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['link_color'] ) ) {
				$color_variables .= '--button-hover-text-color: #111;';
			}
		}

		// Set Top Navigation Color.
		if ( $theme_options['top_navi_color'] != $default_options['top_navi_color'] ) {
			$color_variables .= '--header-bar-background-color: ' . $theme_options['top_navi_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['top_navi_color'] ) ) {
				$color_variables .= '--header-bar-text-color: #111;';
				$color_variables .= '--header-bar-text-hover-color: rgba(0, 0, 0, 0.5);';
			}
		}

		// Set Header Color.
		if ( $theme_options['header_color'] != $default_options['header_color'] ) {
			$color_variables .= '--header-background-color: ' . $theme_options['header_color'] . ';';
			$color_variables .= '--navi-submenu-color: ' . $theme_options['header_color'] . ';';
			$color_variables .= '--site-title-hover-color: rgba(0, 0, 0, 0.5);';
			$color_variables .= '--navi-hover-color: rgba(0, 0, 0, 0.5);';
			$color_variables .= '--navi-border-color: rgba(0, 0, 0, 0.1);';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['header_color'] ) ) {
				$color_variables .= '--site-title-color: #fff;';
				$color_variables .= '--site-title-hover-color: rgba(255, 255, 255, 0.5);';
				$color_variables .= '--navi-color: #fff;';
				$color_variables .= '--navi-hover-color: rgba(255, 255, 255, 0.5);';
				$color_variables .= '--navi-border-color: rgba(255, 255, 255, 0.1);';
			}
		}

		// Set Title Color.
		if ( $theme_options['title_color'] != $default_options['title_color'] ) {
			$color_variables .= '--title-color: ' . $theme_options['title_color'] . ';';
			$color_variables .= '--widget-title-color: ' . $theme_options['title_color'] . ';';
		}

		// Set Footer Widgets Color.
		if ( $theme_options['footer_widgets_color'] != $default_options['footer_widgets_color'] ) {
			$color_variables .= '--footer-widgets-background-color: ' . $theme_options['footer_widgets_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_widgets_color'] ) ) {
				$color_variables .= '--footer-widgets-text-color: #111;';
				$color_variables .= '--footer-widgets-link-color: rgba(0, 0, 0, 0.75);';
				$color_variables .= '--footer-widgets-link-hover-color: rgba(0, 0, 0, 0.5);';
			}
		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] != $default_options['footer_color'] ) {
			$color_variables .= '--footer-background-color: ' . $theme_options['footer_color'] . ';';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['footer_color'] ) ) {
				$color_variables .= '--footer-text-color: #fff;';
				$color_variables .= '--footer-border-color: rgba(255, 255, 255, 0.1);';
			}
		}

		// Set Color Variables.
		if ( '' !== $color_variables ) {
			$custom_css .= ':root {' . $color_variables . '}';
		}

		return $custom_css;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'palm_beach_pro_section_colors', array(
			'title'    => __( 'Theme Colors', 'palm-beach-pro' ),
			'priority' => 70,
			'panel'    => 'palm_beach_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Palm_Beach_Pro_Customizer::get_default_options();

		// Add Top Navigation Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[top_navi_color]', array(
			'default'           => $default_options['top_navi_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[top_navi_color]', array(
				'label'    => _x( 'Top Navigation', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[top_navi_color]',
				'priority' => 10,
			)
		) );

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[header_color]', array(
				'label'    => _x( 'Header', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[header_color]',
				'priority' => 20,
			)
		) );

		// Add Content Primary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[link_color]', array(
				'label'    => _x( 'Links and Buttons', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[link_color]',
				'priority' => 30,
			)
		) );

		// Add Content Secondary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[title_color]', array(
				'label'    => _x( 'Headings', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[title_color]',
				'priority' => 40,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[footer_widgets_color]', array(
			'default'           => $default_options['footer_widgets_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[footer_widgets_color]', array(
				'label'    => _x( 'Footer Widgets', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[footer_widgets_color]',
				'priority' => 50,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[footer_color]', array(
				'label'    => _x( 'Footer', 'color setting', 'palm-beach-pro' ),
				'section'  => 'palm_beach_pro_section_colors',
				'settings' => 'palm_beach_theme_options[footer_color]',
				'priority' => 60,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Palm_Beach_Pro_Custom_Colors', 'setup' ) );

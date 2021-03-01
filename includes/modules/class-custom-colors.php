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

		// Set Title Color.
		if ( $theme_options['title_color'] != $default_options['title_color'] ) {
			$color_variables .= '--page-background-color: ' . $theme_options['page_bg_color'] . ';';

			$custom_css .= '
				.widget-title,
				.widget-title a:link,
				.widget-title a:visited,
				.header-title-background .page-header .header-title,
				.archive-title,
				.page-title,
				.entry-title,
				.entry-title a:link,
				.entry-title a:visited,
				.comments-header .comments-title,
				.comment-reply-title span,
				.related-posts-title {
					color: ' . $theme_options['title_color'] . ';
				}

				.widget-title a:hover,
				.widget-title a:active,
				.entry-title a:hover,
				.entry-title a:active {
					color: #57b7d7;
				}
			';
		}

		// Set Primary Content Color.
		if ( $theme_options['link_color'] != $default_options['link_color'] ) {

			$custom_css .= '
				a,
				a:link,
				a:visited,
				.site-title a:hover,
				.site-title a:active,
				.main-navigation ul a:hover,
				.main-navigation ul a:active,
				.primary-menu-toggle:hover,
				.primary-menu-toggle:active,
				.widget-title a:hover,
				.widget-title a:active,
				.entry-title a:hover,
				.entry-title a:active,
				.footer-navigation-menu a:hover,
				.footer-navigation-menu a:active,
				.footer-social-icons .social-icons-menu li a:hover:before,
				.has-primary-color {
					color: ' . $theme_options['link_color'] . ';
				}

				.primary-menu-toggle:hover .icon,
				.primary-menu-toggle:active .icon,
				.main-navigation .dropdown-toggle:hover .icon,
				.main-navigation .dropdown-toggle:active .icon,
				.main-navigation ul .menu-item-has-children > a:hover > .icon,
				.main-navigation ul .menu-item-has-children > a:active > .icon {
					fill: ' . $theme_options['link_color'] . ';
				}

				a:hover,
				a:focus,
				a:active {
					color: #242424;
				}

				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				button:focus,
				input[type="button"]:focus,
				input[type="reset"]:focus,
				input[type="submit"]:focus,
				button:active,
				input[type="button"]:active,
				input[type="reset"]:active,
				input[type="submit"]:active,
				.more-link:hover,
				.more-link:focus,
				.more-link:active,
				.widget_tag_cloud .tagcloud a:hover,
				.widget_tag_cloud .tagcloud a:active,
				.entry-tags .tags-title,
				.entry-tags .meta-tags a:hover,
				.entry-tags .meta-tags a:active,
				.post-navigation .nav-links a:hover,
				.post-navigation .nav-links a:active,
				.pagination a:hover,
				.pagination a:active,
				.pagination .current,
				.infinite-scroll #infinite-handle span:hover,
				.infinite-scroll #infinite-handle span:active,
				.reply .comment-reply-link:hover,
				.reply .comment-reply-link:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a.current-tab,
				.tzwb-social-icons .social-icons-menu li a:link,
				.tzwb-social-icons .social-icons-menu li a:visited,
				.scroll-to-top-button:hover {
					border-color: ' . $theme_options['link_color'] . ';
					background: ' . $theme_options['link_color'] . ';
				}

				.tzwb-social-icons .social-icons-menu li a:hover,
				.tzwb-social-icons .social-icons-menu li a:active {
					background: #242424;
				}

				.has-primary-background-color {
					background-color: ' . $theme_options['link_color'] . ';
				}
			';
		}

		// Set Top Navigation Color.
		if ( $theme_options['top_navi_color'] != $default_options['top_navi_color'] ) {

			$custom_css .= '
				.header-bar-wrap,
				.top-navigation ul ul {
					background: ' . $theme_options['top_navi_color'] . ';
				}
			';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['top_navi_color'] ) ) {
				$custom_css .= '
					.top-navigation ul a,
					.top-navigation ul a:link,
					.top-navigation ul a:visited,
					.secondary-menu-toggle,
					.secondary-menu-toggle:focus,
					.header-bar .social-icons-menu li a:link,
					.header-bar .social-icons-menu li a:visited {
					    color: #000;
					}

					.secondary-menu-toggle .icon,
					.top-navigation .dropdown-toggle .icon,
					.top-navigation ul .menu-item-has-children > a > .icon {
						fill:  #000;
					}

					.top-navigation ul a:hover,
					.top-navigation ul a:active,
					.secondary-menu-toggle:hover,
					.secondary-menu-toggle:active,
					.header-bar .social-icons-menu li a:hover,
					.header-bar .social-icons-menu li a:active {
						color: rgba(0,0,0,0.4);
					}

					.secondary-menu-toggle:hover .icon,
					.secondary-menu-toggle:active .icon,
					.top-navigation .dropdown-toggle:hover .icon,
					.top-navigation .dropdown-toggle:active .icon,
					.top-navigation ul .menu-item-has-children > a:hover > .icon,
					.top-navigation ul .menu-item-has-children > a:active > .icon {
						fill: rgba(0,0,0,0.4);
					}
				';
			}
		}

		// Set Header Color.
		if ( $theme_options['header_color'] != $default_options['header_color'] ) {

			$custom_css .= '
				.site-header,
				.main-navigation ul ul,
				.main-navigation > ul > li.menu-item-has-children > ul {
					background: ' . $theme_options['header_color'] . ';
				}

				.site-header {
					border-bottom: 1px solid rgba(0,0,0,0.075);
				}

				.main-navigation ul ul,
				.main-navigation > ul > li.menu-item-has-children > ul {
					border: 1px solid rgba(0,0,0,0.075);
				}

				.main-navigation ul ul a {
					background: rgba(0,0,0,0.025);
				}

				@media only screen and (max-width: 60em) {
					.main-navigation-menu {
						border-top: 1px solid rgba(0,0,0,0.1);
					}
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['header_color'] ) ) {
				$custom_css .= '
					.site-title a:link,
					.site-title a:visited,
					.main-navigation ul a,
					.main-navigation ul a:link,
					.main-navigation ul a:visited,
					.primary-menu-toggle,
					.primary-menu-toggle:focus {
					    color: #fff;
					}

					.primary-menu-toggle .icon,
					.main-navigation .dropdown-toggle .icon,
					.main-navigation ul .menu-item-has-children > a > .icon {
						fill:  #fff;
					}

					.site-title a:hover,
					.site-title a:active,
					.main-navigation ul a:hover,
					.main-navigation ul a:active,
					.primary-menu-toggle:hover,
					.primary-menu-toggle:active {
						color: rgba(255,255,255,0.5);
					}

					.primary-menu-toggle:hover .icon,
					.primary-menu-toggle:active .icon,
					.main-navigation .dropdown-toggle:hover .icon,
					.main-navigation .dropdown-toggle:active .icon,
					.main-navigation ul .menu-item-has-children > a:hover > .icon,
					.main-navigation ul .menu-item-has-children > a:active > .icon {
						fill: rgba(255,255,255,0.5);
					}

					.main-navigation > ul {
						border-color: rgba(255,255,255,0.1);
					}
				';
			}
		}

		// Set Footer Widgets Color.
		if ( $theme_options['footer_widgets_color'] != $default_options['footer_widgets_color'] ) {

			$custom_css .= '
				.footer-widgets-background {
					background: ' . $theme_options['footer_widgets_color'] . ';
				}
			';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_widgets_color'] ) ) {
				$custom_css .= '
					.footer-widgets-background {
						border-top: 1px solid rgba(0,0,0,0.1);
					}

					.footer-widgets .widget,
					.footer-widgets .widget-title,
					.footer-widgets .widget a:link,
					.footer-widgets .widget a:visited  {
						color: rgba(0,0,0,0.75);
					}

					.footer-widgets .widget a:hover,
					.footer-widgets .widget a:active  {
						color: rgba(0,0,0,0.5);
					}
				';
			}
		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] != $default_options['footer_color'] ) {

			$custom_css .= '
				.footer-wrap {
					background: ' . $theme_options['footer_color'] . ';
					border-top: 1px solid rgba(0,0,0,0.1);
				}

				.site-footer .site-info a:link,
				.site-footer .site-info a:visited,
				.footer-navigation-menu a:link,
				.footer-navigation-menu a:visited {
					color: rgba(0,0,0,0.5);
				}

				.site-footer .site-info a:hover,
				.site-footer .site-info a:active,
				.footer-navigation-menu a:hover,
				.footer-navigation-menu a:active {
					color: rgba(0,0,0,0.75);
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['footer_color'] ) ) {
				$custom_css .= '
					.site-footer {
						color: #fff;
					}

					.site-footer .site-info a:link,
					.site-footer .site-info a:visited,
					.footer-navigation-menu a:link,
					.footer-navigation-menu a:visited {
						color: rgba(255,255,255,0.5)
					}

					.site-footer .site-info a:hover,
					.site-footer .site-info a:active,
					.footer-navigation-menu a:hover,
					.footer-navigation-menu a:active {
						color: rgba(255,255,255,0.75);
					}
				';
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
			'priority' => 60,
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
			'transport'         => 'refresh',
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
			'transport'         => 'refresh',
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

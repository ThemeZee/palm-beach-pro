<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Palm Beach Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

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

		// Set Top Navigation Color.
		if ( $theme_options['top_navi_color'] != $default_options['top_navi_color'] ) {

			$custom_css .= '
				/* Top Navigation Color Setting */
				.header-bar-wrap,
				.top-navigation-menu ul {
					background: '. $theme_options['top_navi_color'] .';
				}
				';

		}

		// Set Header Color.
		if ( $theme_options['header_color'] != $default_options['header_color'] ) {

			$custom_css .= '
				/* Header Color Setting */
				.site-header,
				.main-navigation-menu ul {
					background: '. $theme_options['header_color'] .';
				}
				';

		}

		// Set Primary Content Color.
		if ( $theme_options['content_primary_color'] != $default_options['content_primary_color'] ) {

			$custom_css .= '
				/* Content Primary Color Setting */
				.widget-title,
				.widget-title a:link,
				.widget-title a:visited,
				.archive-title,
				.page-title,
				.entry-title,
				.entry-title a:link,
				.entry-title a:visited,
				.comments-header .comments-title,
				.comment-reply-title span,
				.related-posts-title {
					color: '. $theme_options['content_primary_color'] .';
				}

				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.more-link,
				.post-navigation .nav-links a,
				.post-pagination a,
				.post-pagination .current,
				.infinite-scroll #infinite-handle span,
				.reply .comment-reply-link,
				.tzwb-tabbed-content .tzwb-tabnavi li a {
					background: '. $theme_options['content_primary_color'] .';
				}

				.widget-header,
				.comments-header,
				.comment-reply-title,
				.related-posts-header {
					border-left: 6px solid '. $theme_options['content_primary_color'] .';
				}
				';

		}

		// Set Link Color.
		if ( $theme_options['content_secondary_color'] != $default_options['content_secondary_color'] ) {

			$custom_css .= '
				/* Content Secondary Color Setting */
				a,
				a:link,
				a:visited,
				.widget-title a:hover,
				.widget-title a:active,
				.entry-title a:hover,
				.entry-title a:active {
					color: '. $theme_options['content_secondary_color'] .';
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
				.widget_tag_cloud .tagcloud a,
				.entry-tags .meta-tags a,
				.post-navigation .nav-links a:hover,
				.post-navigation .nav-links a:active,
				.post-pagination a:hover,
				.post-pagination a:active,
				.post-pagination .current,
				.infinite-scroll #infinite-handle span:hover,
				.infinite-scroll #infinite-handle span:active,
				.reply .comment-reply-link:hover,
				.reply .comment-reply-link:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a.current-tab,
				.tzwb-social-icons .social-icons-menu li a {
					background: '. $theme_options['content_secondary_color'] .';
				}
				';

		}

		// Set Primary Content Color.
		if ( $theme_options['content_primary_color'] != $default_options['content_primary_color'] ) {

			$custom_css .= '
				/* Content Primary Color Setting */
				a:hover,
				a:focus,
				a:active {
					color: '. $theme_options['content_primary_color'] .';
				}

				.widget_tag_cloud .tagcloud a:hover,
				.widget_tag_cloud .tagcloud a:active,
				.entry-tags .meta-tags a:hover,
				.entry-tags .meta-tags a:active,
				.tzwb-social-icons .social-icons-menu li a:hover,
				.tzwb-social-icons .social-icons-menu li a:active {
					background: '. $theme_options['content_primary_color'] .';
				}
				';

		}

		// Set Footer Widgets Color.
		if ( $theme_options['footer_widgets_color'] != $default_options['footer_widgets_color'] ) {

			$custom_css .= '

				/* Footer Widget Color Setting */
				.footer-widgets-wrap {
					background: '. $theme_options['footer_widgets_color'] .';
				}
				';

		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] != $default_options['footer_color'] ) {

			$custom_css .= '

				/* Footer Color Setting */
				.footer-wrap {
					background: '. $theme_options['footer_color'] .';
				}
				';

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
			'panel' => 'palm_beach_options_panel',
			)
		);

		// Get Default Colors from settings.
		$default_options = Palm_Beach_Pro_Customizer::get_default_options();

		// Add Top Navigation Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[top_navi_color]', array(
			'default'           => $default_options['top_navi_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[top_navi_color]', array(
				'label'      => _x( 'Top Navigation', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[top_navi_color]',
				'priority' => 1,
			)
		) );

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[header_color]', array(
				'label'      => _x( 'Header', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[header_color]',
				'priority' => 2,
			)
		) );

		// Add Content Primary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[content_primary_color]', array(
			'default'           => $default_options['content_primary_color'],
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[content_primary_color]', array(
				'label'      => _x( 'Content (primary)', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[content_primary_color]',
				'priority' => 3,
			)
		) );

		// Add Content Secondary Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[content_secondary_color]', array(
			'default'           => $default_options['content_secondary_color'],
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[content_secondary_color]', array(
				'label'      => _x( 'Content (secondary)', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[content_secondary_color]',
				'priority' => 4,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[footer_widgets_color]', array(
			'default'           => $default_options['footer_widgets_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[footer_widgets_color]', array(
				'label'      => _x( 'Footer Widgets', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[footer_widgets_color]',
				'priority' => 5,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'palm_beach_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'palm_beach_theme_options[footer_color]', array(
				'label'      => _x( 'Footer', 'color setting', 'palm-beach-pro' ),
				'section'    => 'palm_beach_pro_section_colors',
				'settings'   => 'palm_beach_theme_options[footer_color]',
				'priority' => 6,
			)
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Palm_Beach_Pro_Custom_Colors', 'setup' ) );

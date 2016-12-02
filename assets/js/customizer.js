/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Palm Beach Pro
 */

( function( $ ) {

	/* Top Navigation Color Option */
	wp.customize( 'palm_beach_theme_options[top_navi_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.header-bar-wrap, .top-navigation-menu ul' )
				.css( 'background', newval );
		} );
	} );

	/* Header Color Option */
	wp.customize( 'palm_beach_theme_options[header_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header, .main-navigation-menu ul' )
				.css( 'background', newval );
		} );
	} );

	/* Footer Widgets Color Option */
	wp.customize( 'palm_beach_theme_options[footer_widgets_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-widgets-wrap' )
				.css( 'background', newval );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'palm_beach_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-wrap' )
				.css( 'background', newval );
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'palm_beach_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( 'body, button, input, select, textarea' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'palm_beach_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.site-title, .archive-title, .page-title, .entry-title' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'palm_beach_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.main-navigation-menu a' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'palm_beach_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-widget-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-widget-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-widget-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.comments-header .comments-title, .comment-reply-title span, .widget-title' )
				.css( 'font-family', newval );

		} );
	} );

} )( jQuery );

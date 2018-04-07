<?php
/**
 * Custom Font Control for the Customizer
 *
 * @package Palm Beach Pro
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays a custom Font control. Allows to switch fonts for particular elements on the theme.
	 */
	class Palm_Beach_Pro_Customize_Font_Control extends WP_Customize_Control {

		/**
		 * Declare the control type. Critical for JS constructor.
		 *
		 * @var string
		 */
		public $type = 'palm_beach_pro_custom_font';

		/**
		 * Localization Strings.
		 *
		 * @var array
		 */
		public $l10n = array();

		/**
		 * Local Fonts Array
		 *
		 * @var array
		 */
		private $local_fonts = false;

		/**
		 * Google Fonts Array
		 *
		 * @var array
		 */
		private $google_fonts = false;

		/**
		 * Setup Font Control
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param String               $id      Control ID.
		 * @param array                $args    Arguments to override class property defaults.
		 * @return void
		 */
		public function __construct( $manager, $id, $args = array() ) {

			// Make Buttons translateable.
			$this->l10n = array(
				'previous' => esc_html__( 'Previous Font', 'palm-beach-pro' ),
				'next'     => esc_html__( 'Next Font', 'palm-beach-pro' ),
				'standard' => esc_html_x( 'Default', 'default font button', 'palm-beach-pro' ),
			);

			// Set Fonts.
			$this->local_fonts = Palm_Beach_Pro_Custom_Fonts::get_local_fonts();
			$this->google_fonts = Palm_Beach_Pro_Custom_Fonts::get_google_fonts();

			parent::__construct( $manager, $id, $args );
		}

		/**
		 * Enqueue Font Control JS
		 *
		 * @return void
		 */
		public function enqueue() {

			// Register and Enqueue Custom Font JS Constructor.
			wp_enqueue_script( 'palm-beach-pro-custom-font-control', PALM_BEACH_PRO_PLUGIN_URL . 'assets/js/custom-font-control.js', array( 'customize-controls' ), PALM_BEACH_PRO_VERSION, true );

		}

		/**
		 * Display Control
		 *
		 * @return void
		 */
		public function render_content() {

			$l10n = json_encode( $this->l10n );

			if ( ! empty( $this->local_fonts ) && ! empty( $this->google_fonts ) ) :
			?>

				<label>
					<span class="customize-control-title" data-l10n="<?php echo esc_attr( $l10n ); ?>" data-font="<?php echo esc_attr( $this->setting->default ); ?>">
						<?php echo esc_html( $this->label ); ?>
					</span>
					<div class="customize-font-select-control">
						<select <?php $this->link(); ?>>
							<optgroup label="<?php esc_html_e( 'Local Fonts', 'palm-beach-pro' ); ?>">
								<?php
								foreach ( $this->local_fonts as $k => $v ) :
									printf( '<option value="%s" %s>%s</option>', $k, selected( $this->value(), $k, false ), $v );
								endforeach;
								?>
							</optgroup>

							<optgroup label="<?php esc_html_e( 'Google Web Fonts', 'palm-beach-pro' ); ?>">
	  							<?php
								foreach ( $this->google_fonts as $k => $v ) :
									printf( '<option value="%s" %s>%s</option>', $k, selected( $this->value(), $k, false ), $v );
								endforeach;
								?>
							</optgroup>
						</select>
					</div>
					<div class="actions"></div>
				</label>

			<?php
			endif;
		}
	}

endif;

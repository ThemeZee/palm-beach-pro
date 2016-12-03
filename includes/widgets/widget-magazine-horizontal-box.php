<?php
/**
 * Magazine Horizontal Box Widget
 *
 * Display the latest posts from a selected category in a horizontal box layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Palm Beach Pro
 */

/**
 * Magazine Widget Class
 */
class Palm_Beach_Pro_Magazine_Horizontal_Box_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'palm-beach-magazine-horizontal-box', // ID.
			esc_html__( 'Magazine: Horizontal Box', 'palm-beach-pro' ), // Name.
			array(
				'classname' => 'palm_beach_magazine_horizontal_box',
				'description' => esc_html__( 'Displays your posts from a selected category in a horizontal box layout. Please use this widget ONLY in the Magazine Homepage widget area.', 'palm-beach-pro' ),
				'customize_selective_refresh' => true,
			) // Args.
		);

		// Delete Widget Cache on certain actions.
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );

	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title'				=> '',
			'category'			=> 0,
		);

		return $defaults;

	}

	/**
	 * Main Function to display the widget
	 *
	 * @uses this->render()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 */
	function widget( $args, $instance ) {

		// Start Output Buffering.
		ob_start();

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output.
		echo $args['before_widget'];
		?>
		<div class="widget-magazine-horizontal-box widget-magazine-posts clearfix">

			<?php // Display Title.
			$this->widget_title( $args, $settings ); ?>

			<div class="widget-magazine-posts-content">

				<?php $this->render( $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// Set Cache.
		ob_end_flush();

	}

	/**
	 * Renders the Widget Content
	 *
	 * Switches between horizontal and vertical layout style based on widget settings
	 *
	 * @uses this->magazine_posts_horizontal() or this->magazine_posts_vertical()
	 * @used-by this->widget()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $settings ) {

		// Get latest posts from database.
		$query_arguments = array(
			'posts_per_page' => 4,
			'ignore_sticky_posts' => true,
			'cat' => (int) $settings['category'],
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Limit the number of words for the excerpt.
			add_filter( 'excerpt_length', array( $this, 'excerpt_length_large_post' ) );

			// Display Posts.
			while ( $posts_query->have_posts() ) : $posts_query->the_post();

				if ( 0 === $i ) :

					// Display excerpt for first post.
					set_query_var( 'palm_beach_post_excerpt', true );

					Palm_Beach_Pro::load_theme_template( 'template-parts/widgets/magazine-content', 'large-post' );

					echo '<div class="magazine-grid magazine-grid-three-columns clearfix">';

					// Display no excerpts for medium posts.
					set_query_var( 'palm_beach_post_excerpt', false );

				else :

					echo '<div class="post-column">';
					Palm_Beach_Pro::load_theme_template( 'template-parts/widgets/magazine-content', 'medium-post' );
					echo '</div>';

				endif; $i++;

			endwhile;

			echo '</div><!-- end .magazine-three-columns -->';

			// Remove excerpt filter.
			remove_filter( 'excerpt_length', array( $this, 'excerpt_length_large_post' ) );

		endif;

		// Reset Postdata.
		wp_reset_postdata();

	}

	/**
	 * Returns the excerpt length in number of words
	 *
	 * @param int $length Length of excerpt in number of words.
	 * @return integer $this->excerpt_length Number of Words
	 */
	function excerpt_length_large_post( $length ) {
		return 30;
	}

	/**
	 * Returns the excerpt length in number of words
	 *
	 * @param int $length Length of excerpt in number of words.
	 * @return integer $this->excerpt_length Number of Words
	 */
	function excerpt_length( $length ) {
		return 10;
	}

	/**
	 * Displays Widget Title
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Category Title.
			if ( $settings['category'] > 0 ) :

				// Set Link URL and Title for Category.
				$link_title = sprintf( __( 'View all posts from category %s', 'palm-beach-pro' ), get_cat_name( $settings['category'] ) );
				$link_url = get_category_link( $settings['category'] );

				// Display Widget Title with link to category archive.
				echo '<div class="widget-header">';
				echo '<h3 class="widget-title"><a class="category-archive-link" href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_title ) . '">' . $widget_title . '</a></h3>';
				echo '<div class="category-description">' . category_description( $settings['category'] ) . '</div>';
				echo '</div>';

			else :

				// Display default Widget Title without link.
				echo $args['before_title'] . $widget_title . $args['after_title'];

			endif;

		endif;

	} // widget_title()


	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];

		$this->delete_widget_cache();

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance.
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'palm-beach-pro' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $settings['title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'palm-beach-pro' ); ?></label><br/>
			<?php // Display Category Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'palm-beach-pro' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category'],
					'name'               => $this->get_field_name( 'category' ),
					'id'                 => $this->get_field_id( 'category' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

	<?php
	} // form()


	/**
	 * Delete Widget Cache
	 */
	public function delete_widget_cache() {

		wp_cache_delete( 'widget_palm_beach_magazine_horizontal_box', 'widget' );

	}
}

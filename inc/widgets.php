<?php
/**
 * Custom Widget for displaying specific post formats
 *
 * Displays posts from Aside, Quote, Video, Audio, Image, Gallery, and Link formats.
 *
 * @link http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 */

class ActionSite_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 */
	public function __construct($id = 'widget_actionsite_widget', $description = 'General Actionsite Widget Class', $opts = array()) {
		parent::__construct( $id, $description, $opts );
	}

	/**
	 * Output the HTML for this widget.
	 *
	 * @access public
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 * @return void Echoes its output.
	 */
	public function widget( $args, $instance ) {

		extract($args);
		$body = ( ! empty( $instance['body'] ) ) ? $instance['body'] : '';
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		echo '<div class="actionsitewidget">'.wpautop($body).'</div>';
		echo $after_widget;

	}

	/**
	 * Deal with the settings when they are saved by the admin.
	 *
	 * Here is where any validation should happen.
	 *
	 *
	 * @param array $new_instance New widget instance.
	 * @param array $instance     Original widget instance.
	 * @return array Updated widget instance.
	 */
	function update( $new_instance, $instance ) {
		$instance['body'] = $new_instance['body'];
		return $instance;
	}

	/**
	 * Display the form for this widget on the Widgets page of the Admin area.
	 *
	 *
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		$body  = empty( $instance['body'] ) ? '' : $instance['body'];
		?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'body' ) ); ?>"><?php _e( 'Body:', 'actionsite' ); ?></label>
			<textarea id="<?php echo esc_attr( $this->get_field_id( 'body' ) ); ?>" class="widefat" rows="16" cols="20" name="<?php echo esc_attr( $this->get_field_name( 'body' ) ); ?>"><?php echo $body; ?></textarea></p>
		<?php
	}
}

class ActionSite_Who_Widget extends ActionSite_Widget {

	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		parent::__construct( 'widget_actionsite_who_widget', __( 'Who We Are', 'actionsite' ), array(
			'classname'   => 'widget_actionsite_who_widget',
			'description' => __( 'Who We Are Widget', 'actionsite' ),
		) );
	}

	public function widget( $args, $instance ) {

		extract($args);
		$body = ( ! empty( $instance['body'] ) ) ? $instance['body'] : '';
		echo $before_widget;
		echo $before_title . 'Who We Are' . $after_title;
		echo '<div class="actionsitewidget">'.wpautop($body).'</div>';
		echo $after_widget;

	}

}

class ActionSite_Info_Widget extends ActionSite_Widget {

	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		parent::__construct( 'widget_actionsite_info_widget', __( 'Get More Information', 'actionsite' ), array(
			'classname'   => 'widget_actionsite_info_widget',
			'description' => __( 'Get More Information Widget', 'actionsite' ),
		) );
	}

	public function widget( $args, $instance ) {

		extract($args);
		$body = ( ! empty( $instance['body'] ) ) ? $instance['body'] : '';
		echo $before_widget;
		echo $before_title . 'Get More Information' . $after_title;
		echo '<div class="actionsitewidget">'.wpautop($body).'</div>';
		echo $after_widget;

	}

}

class ActionSite_Support_Widget extends ActionSite_Widget {

	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		parent::__construct( 'widget_actionsite_support_widget', __( 'Support Our Work', 'actionsite' ), array(
			'classname'   => 'widget_actionsite_support_widget',
			'description' => __( 'Support Our Work Widget', 'actionsite' ),
		) );
	}

	public function widget( $args, $instance ) {

		extract($args);
		$body = ( ! empty( $instance['body'] ) ) ? $instance['body'] : '';
		echo $before_widget;
		echo $before_title . 'Support Our Work' . $after_title;
		echo '<div class="actionsitewidget">'.wpautop($body).'</div>';
		echo $after_widget;

	}

}

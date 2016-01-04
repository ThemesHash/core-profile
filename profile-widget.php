<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Core Profile
	Plugin URI: http://themeshash.com/wordpress-plugins/
	Description: A widget that displays blog owner's information via widget.
	Version: 1.0
	Author: Muhammad Faisal
	Author URI: http://themeshash.com/

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'th_about_widget_init' );

// Register widget
function th_about_widget_init() {
	register_widget( 'th_about_widget' );
}

// Widget class
class th_about_widget extends WP_Widget {


	#-------------------------------------------------------------------------------#
	#  Widget Setup
	#-------------------------------------------------------------------------------#
	
	function __construct() {

		// Widget settings
		$widget_ops = array(
			'classname' => 'widget-about',
			'description' => esc_html__('A widget that displays blog owner\'s information.', 'themeshash')
		);

		// Widget control settings
		$control_ops = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'th_about_widget'
		);

		// Create the widget
		parent::__construct( 'th_about_widget', esc_html__('About Me', 'themeshash'), $widget_ops, $control_ops );
		
	}


	#-------------------------------------------------------------------------------#
	#  Display Widget
	#-------------------------------------------------------------------------------#
	
	public function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$img_url = $instance['img_url'];
		$desc = $instance['desc'];

		// Before widget (defined by theme functions file)
		echo wp_kses_post( $before_widget );

		// Display the widget title if one was input
		if ( $title )
			echo wp_kses_post( $before_title . $title . $after_title );

		?>
	     
        <div class="widget-content">
            
	    	<?php do_action( 'th_before_about_widget' ); ?>

	    	<?php if( !empty($img_url) ) { ?>
	            <div class="author-avatar"><img src="<?php echo esc_url( $img_url ); ?>" /></div>
	    	<?php } ?>                

	    	<?php if( !empty($name) ) { ?>
	            <div class="author-name"><?php echo esc_html( $name ); ?></div>
	    	<?php } ?>
	    	             
	    	<?php if( !empty($desc) ) { ?>
                <div class="author-desc"><?php echo esc_html( $desc ); ?></div>		    	
	    	<?php } ?>

	    	<?php do_action( 'th_after_about_widget' ); ?>
                        
        </div>

		<?php

		// After widget (defined by theme functions file)
		echo wp_kses_post( $after_widget );
		
	}

	#-------------------------------------------------------------------------------#
	#  Update Widget
	#-------------------------------------------------------------------------------#
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['img_url'] = strip_tags( $new_instance['img_url'] );
		$instance['desc'] = strip_tags( $new_instance['desc'] );

		// No need to strip tags
		return $instance;
	}

	#-------------------------------------------------------------------------------#
	#  Widget Settings
	#-------------------------------------------------------------------------------#
		 
	public function form( $instance ) {

		// Set up some default widget settings
		$defaults = array(
			'title' => 'About Me',
			'name' => '',
			'img_url' => '',
			'desc' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'themeshash') ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<!-- Name: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e('Name:', 'themeshash') ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" />
		</p>

		<!-- Image URL: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'img_url' ) ); ?>"><?php esc_html_e('Image URL:', 'themeshash') ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'img_url' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['img_url'] ); ?>" />
		</p>

		<!-- Desc: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php esc_html_e('Description:', 'themeshash') ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>" rows="6" value="<?php echo esc_attr( $instance['desc'] ); ?>"><?php echo esc_attr( $instance['desc'] ); ?></textarea>
		</p>

		<?php

	}

}
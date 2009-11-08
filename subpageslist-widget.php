<?php

/**

 * Plugin Name: SubpagesList Widget

 * Plugin URI: http://downloads.vitali-software.com/subpages-widget.zip

 * Description: A widget to display the list of only the subpages of a specific page.

 * Version: 1.0

 * Author: Amelie Husson

 * Author URI: http://www.vitali-software.com

 *

 * This program is distributed in the hope that it will be useful,

 * but WITHOUT ANY WARRANTY; without even the implied warranty of

 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

 */



/* Load */

add_action( 'widgets_init', 'subpages_load_widgets' );



/* Register */

function subpages_load_widgets() {

	register_widget( 'Subpages_Widget' );

}



class Subpages_Widget extends WP_Widget {

	

	/*Setup*/

	function Subpages_Widget() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'subpages', 'description' => __('A widget to display the list of only subpages of a specific parent page', 'subpages') );



		/* Widget control settings. */

		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'subpages-widget' );



		/* Create the widget. */

		$this->WP_Widget( 'subpages-widget', __('Subpages Widget', 'subpages'), $widget_ops, $control_ops );

	}

	

	/* Display */

	function widget( $args, $instance ) {

		extract( $args );



		/* Our variables from the widget settings. */

		$title = apply_filters('widget_title', $instance['title'] );

		$parent = $instance['parent'];

		$depth = $instance['depth'];

		$sort = $instance['sort'];



		/* Before widget (defined by themes). */

		echo $before_widget;



		/* Display the widget title if one was input (before and after defined by themes). */

		if ( $title )

			echo $before_title . $title . $after_title;



		/* Display subpages list. */

		echo '<ul>';

		wp_list_pages(array(

			'sort_column'	=> $sort,

			'depth'			=> $depth,

			'child_of'		=> $parent,

			'title_li'		=>''

			));

		echo '</ul>';



		/* After widget (defined by themes). */

		echo $after_widget;

	}

	

	/* Update settings */

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['parent'] = $new_instance['parent'];

		$instance['sort'] = $new_instance['sort'];

		$instance['depth'] = $new_instance['depth'];

		return $instance;

	}

	

	/* Settings control */

	function form( $instance ) {



		$defaults = array( 'title' => __('Subpages', 'subpages'), 'name' => __('About', 'subpages'), 'show_parent' => true, 'depth' => 1 );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>



		<!-- Widget Title: Text Input -->

		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>

			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />

		</p>



		<!-- Parent: Select Box -->

		<p>

			<label for="<?php echo $this->get_field_id( 'parent' ); ?>"><?php _e('The parent page name:', 'subpages'); ?></label>

			<select id="<?php echo $this->get_field_id( 'parent' ); ?>" name="<?php echo $this->get_field_name( 'parent' ); ?>" class="widefat" style="width:100%;">

				<?php

				$pages = get_pages();

				foreach ($pages as $page) { 

				?>

					<option value="<?php echo $page->ID ?>" <?php if ( $page->ID == $instance['parent'] ) echo 'selected="selected"'; ?>><?php echo $page->post_title ?></option>

				<?php } ?>

			</select>

		</p>

		

		<!-- Sort by: Select Box -->

		<p>

			<label for="<?php echo $this->get_field_id( 'sort' ); ?>"><?php _e('Sort subpages by:', 'subpages'); ?></label>

			<select id="<?php echo $this->get_field_id( 'sort' ); ?>" name="<?php echo $this->get_field_name( 'sort' ); ?>" class="widefat" style="width:100%;">

				<option value="post_title" <?php if ( 'post_title' == $instance['sort'] ) echo 'selected="selected"'; ?>>Page Title</option>

				<option value="menu_order" <?php if ( 'menu_order' == $instance['sort'] ) echo 'selected="selected"'; ?>>Menu Order</option>

				<option value="post_date" <?php if ( 'post_date' == $instance['sort'] ) echo 'selected="selected"'; ?>>Page Date</option>

				<option value="ID" <?php if ( 'ID' == $instance['sort'] ) echo 'selected="selected"'; ?>>ID</option>

				<option value="post_name" <?php if ( 'post_name' == $instance['sort'] ) echo 'selected="selected"'; ?>>Page slug</option>

			</select>

		</p>



		<!-- Depth: Select Box -->

		<p>

			<label for="<?php echo $this->get_field_id( 'depth' ); ?>"><?php _e('Depth:', 'subpages'); ?></label> 

			<select id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" class="widefat" style="width:100%;">

				<option <?php if ( '1' == $instance['depth'] ) echo 'selected="selected"'; ?>>1</option>

				<option <?php if ( '2' == $instance['depth'] ) echo 'selected="selected"'; ?>>2</option>

				<option <?php if ( '3' == $instance['depth'] ) echo 'selected="selected"'; ?>>3</option>

				<option <?php if ( '4' == $instance['depth'] ) echo 'selected="selected"'; ?>>4</option>

			</select>

		</p>



	<?php

	}

}

?>
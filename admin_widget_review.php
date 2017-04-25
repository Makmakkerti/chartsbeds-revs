<?php
add_action( 'widgets_init', 'cbreviews_widget' );

function cbreviews_widget() {
    register_widget( 'CBreviews_Widget' );
}

class CBreviews_Widget extends WP_Widget {

    function CBreviews_Widget() {
        $widget_ops = array( 'classname' => 'reviews', 'description' => __('A widget that displays hotels review', 'reviews') );

        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'reviews-widget' );

        $this->WP_Widget( 'reviews-widget', __('Chartsbeds review recent', 'reviews'), $widget_ops, $control_ops );

    }

    function widget( $args, $instance ) {
        extract( $args );

        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;

        echo $before_widget."<div class='cb-widget'>";

        // Display the widget title
        if ( $title ){
            echo $before_title . $title . $after_title;
        }

        // Use shortcode in a PHP file (outside the post editor).
        echo do_shortcode( '[chartsbeds-review-recent]' );

        echo $after_widget."</div>";
    }

    //Update the widget

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['show_info'] = $new_instance['show_info'];

        return $instance;
    }


    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array( 'title' => __('Hotel name', 'reviews'), 'name' => __('ChartsBeds', 'reviews'), 'show_info' => true );
        $instance = wp_parse_args( (array) $instance, $defaults );

        //Widget Title: Text Input.
        echo '<p>';
        echo '<label for="'.$this->get_field_id( 'title' ).'">';
        _e('Title:', 'reviews');
        echo '</label>';
        echo '<input id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" value="'.$instance['title'].'" style="width:100%;" />';
        echo '</p>';
    }
}
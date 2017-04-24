<?php

function cbreview_widget_shortcode($atts) {
    $cba = shortcode_atts( array(
        'limit' => esc_attr($cba['limit']),
    ), $atts );

    if(empty($cba['limit'])){
        $cba['limit'] = 4;
    }

    /*Adding settings page to Admin Panel*/
    function charts_admin() {
        include('chartsbeds_admin.php');
    }

    function charts_admin_actions() {
        add_menu_page("Chartsbeds", "Chartsbeds", 1, "Chartsbeds", "charts_admin", plugins_url()."/chartsbeds-review/chartsbeds_ico.png", 7);
        //Description of recieved data:( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }

    add_action('admin_menu', 'charts_admin_actions');?>

    <!--Start comments Widget -->
    <head>
        <style>
            .cwheader{
                background-color: #537cb4 !important;
            }

            .cwheader h3{
                color: #fff !important;
            }
            .media-heading{
                line-height: 18px;
            }
            .charts-widg{
                float: right;
                padding-right: 10px;
                line-height: 12;
                margin-top: 5px;
            }
            .media-left{
                float: left;
                width: 20%;
                margin-right: 10px;
            <?php if(!empty(get_option("gravataroff"))) echo "display:none;";?>
            }
            .revdate{
                float: right;
                font-size: 11px;
            }
            .charts-widg-p{
                margin: 0;
                line-height: 14px;
                font-size: 12px;
                font-family: Arial;
            }
        </style>
    </head>

    <body>

    <!-- Fluid width widget -->
    <div class="panel panel-default">
        <!--div class="panel-heading cwheader">
            <h3 class="panel-title">
                <span class="fa fa-comments-o"></span> 
                Recent reviews
            </h3>
        </div-->
        <div class="panel-body">
            <ul class="media-list">
                <?php $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'&limit='.esc_attr($cba['limit']).'');
                $obj = json_decode($json, true);

                foreach ($obj as $title => $data){
                    $counter = 1;
                    foreach($data as $q=>$res) {
                        if(is_array($res)){?>
                            <li class="media">
                                <div class="media-left">
                                    <img src="<?php echo $res['gravatar'];?>" class="img-circle" width="60px">
                                </div>
                                <div class="media-body">
                                    <span class="revdate"><?php echo $res['timestamp'];?></span>
                                    <h4 class="media-heading">
                                        <small><b><?php echo ucfirst($res['name']);?></b> <br />from <?php echo $res['country'];?></small><br><small><span class="fa fa-thumbs-up" style="color:#337ab7"></span> <?php echo $res['guest_rating'];?>% Satisfied <br>
                                        </small>
                                    </h4>
                                    <p class="charts-widg-p">
                                        <?php echo $res['review'];?>
                                    </p>
                                    <p class="charts-widg" ><small><span class="fa fa-heart" style="color:red"></span> <?php echo ucfirst($res['name']);?> recommends this hotel</small></p>
                                </div>
                            </li>

                            <hr>
                        <?php }}}?>
                <a href="#" class="btn btn-primary">Go to reviews page»</a>
            </ul>
        </div>
    </div>
    <!-- End fluid width widget -->

    </body>
    <!--End comments Widget -->
<?php }

add_shortcode('chartsbeds-review-recent', 'cbreview_widget_shortcode');

/*The BEGINNING of adding review widget**/

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
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input.-->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'reviews'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>


        <?php
    }
}
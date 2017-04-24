<?php
/*Widget Reviews Progressbar*/
function widget_bar_creation(){

    $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'');
    $obj = json_decode($json, true);

    $clean = $obj['reviews_average']['cleanliness'];
    $loca = $obj['reviews_average']['location'];
    $staf = $obj['reviews_average']['staff'];
    $room = $obj['reviews_average']['rooms'];
    $fun = $obj['reviews_average']['fun'];

    $arrPercent = array(
        "cleanliness" => $clean,
        "location" => $loca,
        "staff" => $staf,
        "rooms" => $room,
        "fun" => $fun,
    );?>


    <html>
    <head>
        <style>
            .progress-1 {
                background-color: #4B253A;
            }

            .progress-2 {
                background-color: #EFB917;
            }

            .progress-3 {
                background-color: #45AEEA;
            }

            .progress-4 {
                background-color: #D2D558;
            }

            .progress-5 {
                background-color: #D43A43;
            }
        </style>
        <link rel='stylesheet' href='/wp-content/plugins/chartsbeds-review/styles/style.css' type='text/css' media='all' />
        <script type="text/javascript" src="https://viralpatel.net/blogs/demo/jquery/jquery.shorten.1.0.js"></script>

        <script>
            jQuery(document).ready(function() {

                jQuery('.progress .progress-bar').css("width",
                    function() {
                        return jQuery(this).attr("aria-valuenow") + "%";
                    }
                );

                jQuery(".charts-widg-p").shorten({
                    "showChars" : 100,
                    "moreText"	: " See More",
                    "lessText"	: " Less",}
                );

                jQuery(".cb-rev-clients").shorten({
                        "showChars" : 240,
                        "moreText"	: " See More",
                        "lessText"	: " Less",
                    }
                );
                jQuery(".morecontent a").addClass("btn btn-default btn-xs");

                jQuery(".morelink").click(function(){
                    if (jQuery(this).closest( '.rcustomers' ).hasClass( "col-md-10" )){jQuery(this).closest( '.rcustomers' ).removeClass( 'col-md-10' )}else{jQuery(this).closest( '.rcustomers' ).addClass( 'col-md-10' )};
                });



            });

        </script>


    </head>

    <body>

    <!-- Skill Bars -->
    <?php

    $pl = 1;
    foreach($arrPercent as $k=>$v){	?>

        <div class="progress skill-bar ">
            <div class="progress-bar progress-<?php echo $pl;?> progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $v*20;?>" aria-valuemin="0" aria-valuemax="100">
                <span class="skill"><?php echo $k;?><i class="val"><?php echo $v*20;?></i></span>
            </div>
        </div>
        <?php $pl++; }?>

    <!--/div>
</div-->
    </body>
    </html>

<?php }?>

<?php add_shortcode('chartsbeds-review-bar', 'widget_bar_creation');

/***FINISHING TO ADD PLUGIN**/


/***ADDING WIDGET TO ADMINPANEL**/

add_action( 'widgets_init', 'cbbar_widget' );

function cbbar_widget() {
    register_widget( 'CBbar_Widget' );
}

class CBbar_Widget extends WP_Widget {

    function CBbar_Widget() {
        $widget_ops = array( 'classname' => 'wreviews', 'description' => __('A widget that displays hotels review', 'wreviews') );

        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wreviews-widget' );

        $this->WP_Widget( 'wreviews-widget', __('Chartsbeds review bar', 'wreviews'), $widget_ops, $control_ops );

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
        echo do_shortcode( '[chartsbeds-review-bar]' );

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
        $defaults = array( 'title' => __('Hotel name', 'wreviews'), 'name' => __('ChartsBeds', 'wreviews'), 'show_info' => true );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input.-->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wreviews'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>


        <?php
    }
}
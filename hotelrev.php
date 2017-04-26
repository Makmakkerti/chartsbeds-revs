<?php
/*
* Plugin Name: Chartsbeds
* Description: Chartsbeds reviews plugin.
* Version: 1.0
* Author: ChartsBeds
* Author URI: https://chartsbeds.com
*/
    //Exit if accessed directly
    if ( ! defined( 'ABSPATH')){
        exit;
    }

    $pluginPath = plugin_dir_path(__FILE__);
include ( $pluginPath . 'chartsbeds-widget-bar.php' );
include ( $pluginPath . 'chartsbeds-plugin-circle.php' );


include ( $pluginPath . 'chartsbeds-plugin-page.php' );
include ( $pluginPath . 'chartsbeds-widget-review.php' );

include ( $pluginPath . 'admin_widget_review.php' );
include ( $pluginPath . 'admin_widget_bar.php' );

/*ADDING LAST VERSION OF FONT AWSOME*/
add_action('wp_head', 'add_fawesome_mc');
function add_fawesome_mc() {

    wp_enqueue_style( 'rvmain-css', plugins_url( 'styles/style.css', __FILE__ ) );
    wp_register_style( 'rvmain-css', plugins_url( 'styles/style.css', __FILE__ ) );

    wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/4ef6ac5e6d.js' );
    wp_enqueue_script( 'circles', plugins_url( 'scripts/circles.js', __FILE__ ) );
    wp_enqueue_script( 'shorten', plugins_url( 'scripts/shorten.js', __FILE__ ) );
}
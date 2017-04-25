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


    /*ADDING STYLES*/
    wp_enqueue_style( 'chartsbeds-css', plugins_url( 'styles/style.css', __FILE__ ) );
    wp_register_style( 'chartsbeds-css', plugins_url( 'styles/style.css', __FILE__ ) );

    /*ADDING LAST VERSION OF FONT AWSOME*/
    add_action('wp_head', 'add_fawesome_mc');
    function add_fawesome_mc() {
    wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/4ef6ac5e6d.js' );
    }

    /*ADDING SCRIPTS*/
    wp_enqueue_script('circles', plugin_dir_url(__FILE__) . 'scripts/circles.js', array('jquery'));
    wp_enqueue_script('shorten', plugin_dir_url(__FILE__) . 'scripts/shorten.js', array('jquery'));
    wp_enqueue_script('main', plugin_dir_url(__FILE__) . 'scripts/chartsbeds-review.js', array('JQuery'));

    /**/
    $pluginPath = plugin_dir_path(__FILE__);
    include ( $pluginPath . 'chartsbeds-plugin-page.php' );
    include ( $pluginPath . 'chartsbeds-widget-review.php' );
    include ( $pluginPath . 'chartsbeds-widget-bar.php' );
    include ( $pluginPath . 'chartsbeds-plugin-circle.php' );








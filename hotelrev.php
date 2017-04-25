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

    wp_enqueue_style( 'chartsbeds-css', plugins_url( 'styles/style.css', __FILE__ ) );
    wp_register_style( 'chartsbeds-css', plugins_url( 'styles/style.css', __FILE__ ) );


    $pluginPath = plugin_dir_path(__FILE__);

	require ( $pluginPath . 'chartsbeds-widget-bar.php' );
	require ( $pluginPath . 'chartsbeds-widget-review.php' );
	require ( $pluginPath . 'chartsbeds-plugin-circle.php' );
    require ( $pluginPath . 'chartsbeds-plugin-page.php' );



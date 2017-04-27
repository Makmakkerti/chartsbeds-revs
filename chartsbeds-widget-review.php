<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function cbeds_review_widget_shortcode($atts) {
    $cba = shortcode_atts( array(
        'limit' => esc_attr($cba['limit']),
    ), $atts );

    if(empty($cba['limit'])){
        if(empty(get_option('rec_amt'))) {
            $cba['limit'] = 4;
        }else{
            $cba['limit'] = get_option('rec_amt');
        }
    }

    echo '<script>';
    echo 'jQuery(document).ready(function() {';
    echo 'jQuery(".charts-widg-p").shorten({ "showChars" : 100, "moreText": " See More", "lessText": " Less",});';
    echo 'jQuery(".cb-rev-clients").shorten({"showChars" : 100, "moreText"	: " See More", "lessText"	: " Less",});';
    echo 'jQuery(".morecontent a").addClass("btn btn-default btn-xs");';
     echo '});';
    echo '</script>';

    //Start comments Widget
    echo '<div class="panel panel-default">';
        echo '<div class="panel-body">';
            echo '<ul class="media-list">';

                 $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'&limit='.esc_attr($cba['limit']).'');
                 $obj = json_decode($json, true);

                foreach ($obj as $title => $data){
                    $counter = 1;
                    foreach($data as $q=>$res) {
                        if(is_array($res)){
                            echo '<li class="media">';
                            if(empty(get_option("gravataroff"))) echo '<div class="media-left"><img src="'.$res['gravatar'].'" class="img-circle" width="60px"></div>';
                                echo '<div class="media-body">';
                                    echo '<span class="revdate">'.$res['timestamp'].'</span>';
                                    echo '<h4 class="media-heading">';
                                    echo '<small><b>'.ucfirst($res['name']).'</b> <br />from '.$res['country'].'</small><br><small><span class="fa fa-thumbs-up" style="color:#337ab7"></span>';
                                    echo $res['guest_rating'].'% Satisfied <br></small>';
                                    echo '</h4>';
                                    echo '<p class="charts-widg-p">';
                                    echo $res['review'];
                                    echo '</p>';
                                    echo '<p class="charts-widg" ><small><span class="fa fa-heart" style="color:red"></span>';
                                    echo ucfirst($res['name']);
                                    echo ' recommends this hotel</small></p>';
                                echo '</div></li><hr>';
                        }
                    }
                }

                if(!empty(get_option('rev_url')))echo '<a href="'.get_option('rev_url').'" class="btn btn-primary">Go to reviews page</a>';
                echo '</ul></div></div>';

   //End comments Widget
}

add_shortcode('chartsbeds-review-recent', 'cbeds_review_widget_shortcode');
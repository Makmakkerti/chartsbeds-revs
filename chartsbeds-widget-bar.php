<?php
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
    );

        echo '<script>';
        echo 'jQuery(document).ready(function() {';
        echo 'jQuery(".progress .progress-bar").css("width",function() {return jQuery(this).attr("aria-valuenow") + "%";});';
        echo 'jQuery(".charts-widg-p").shorten({ "showChars" : 100, "moreText": " See More", "lessText": " Less",});';
        echo 'jQuery(".cb-rev-clients").shorten({"showChars" : 100, "moreText"	: " See More", "lessText"	: " Less",});';
        echo 'jQuery(".morecontent a").addClass("btn btn-default btn-xs");';
        echo 'jQuery(".morelink").click(function(){if (jQuery(this).closest( ".rcustomers" ).hasClass( "col-md-10" )){jQuery(this).closest( ".rcustomers" ).removeClass( "col-md-10" )}';
        echo 'else{jQuery(this).closest( ".rcustomers" ).addClass( "col-md-10" )};});});';
        echo '</script>';


    $pl = 1;
    foreach($arrPercent as $k=>$v){
        $the_value = $v*20;
        echo '<div class="progress skill-bar ">';
        echo '<div class="progress-bar progress-'.$pl.' progress-bar-striped active" role="progressbar" aria-valuenow="'.$the_value.'" aria-valuemin="0" aria-valuemax="100">';
        echo '<span class="skill">'.$k.'<i class="val">'.$the_value.'</i></span>';
        echo '</div></div>';
        $pl++; }
    }

add_shortcode('chartsbeds-review-bar', 'widget_bar_creation');
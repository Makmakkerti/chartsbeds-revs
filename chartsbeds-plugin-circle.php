<?php
function rev_creation(){

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

   echo "<script type='text/javascript' src='".plugins_url( 'scripts/circles.js', __FILE__ )."'></script>";
        echo '<div id="canvas">';
            echo '<div class="wrap_circle" style="float:left;"><div class="circle" id="circles-1">cleanliness</div></div>';
            echo '<div class="wrap_circle" style="float:left;"><div class="circle" id="circles-2">location</div></div>';
            echo '<div class="wrap_circle" style="float:left;"><div class="circle" id="circles-3">staff</div></div>';
            echo '<div class="wrap_circle" style="float:left;"><div class="circle" id="circles-4">rooms</div></div>';
            echo '<div class="wrap_circle" style="float:left;"><div class="circle" id="circles-5">fun</div></div>';
        echo '</div>';


    echo '<script type="application/javascript">';
        echo "var colors = [['#D3B6C6', '#4B253A'], ['#FCE6A4', '#EFB917'], ['#BEE3F7', '#45AEEA'], ['#F8F9B6', '#D2D558'], ['#F4BCBF', '#D43A43']], circles = []; \n";

        $i = 1;
        foreach($arrPercent as $k=>$v){
            $c_value = $v*20;
        echo "var child = document.getElementById('circles-".$i."'), percentage = '".$c_value."',";
                $h_color = $i-1;
            echo "circle = Circles.create({ id:child.id,  value:percentage, radius:getWidth(), width:10, colors:colors['".$h_color."'],  duration:900,}); \n";

        $i++; }

    echo "circles.push(circle); \n";
    echo "window.onresize = function(e) {for (var i = 0; i < circles.length; i++) {circles[i].updateRadius(getWidth());}}; \n";
    echo "function getWidth() {return window.innerWidth /25;} \n";
    echo "</script>";
}

add_shortcode('chartsbeds-review-circle', 'rev_creation');
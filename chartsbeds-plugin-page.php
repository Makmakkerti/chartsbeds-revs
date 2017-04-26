<?php
/// Function ADD Reviews to the page
function review_add_shortcode($cbh) {
    $cbh = shortcode_atts( array(
        'limit' => esc_attr($cbh['limit']),
    ), $atts );

    $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'&limit='.esc_attr($cbh['limit']).'');
    $obj = json_decode($json, true);
    
    echo '<script>';
    echo 'jQuery(document).ready(function() {';
    echo 'jQuery(".charts-widg-p").shorten({ "showChars" : 100, "moreText": " See More", "lessText": " Less",});';
    echo 'jQuery(".cb-rev-clients").shorten({"showChars" : 100, "moreText"	: " See More", "lessText"	: " Less",});';
    echo 'jQuery(".morecontent a").addClass("btn btn-default btn-xs");';
    echo 'jQuery(".morelink").click(function(){if (jQuery(this).closest( ".rcustomers" ).hasClass( "col-md-10" )){jQuery(this).closest( ".rcustomers" ).removeClass( "col-md-10" )}else{jQuery(this).closest( ".rcustomers" ).addClass( "col-md-10" )};});';
    echo '});';
    echo '</script>';


    foreach ($obj as $title => $data){
        $counter = 1;
        foreach($data as $q=>$res) {
            if(is_array($res)){
			$g_rates = $res['guest_rating']*0.58;
               echo '<div class="row tinline" >';
               echo '<div class="col-md-5  rcustomers">';
               echo '<div class="testimonials">';
               echo '<div class="active item">';
               echo '<blockquote><p class="cb-rev-clients">'.$res['review'].'</p></blockquote>';
               echo '<div class="testimonials-rate col-md-4">Rating: '.$res['guest_rating'].'';
               echo '<div class="star-ratings">';
               echo '<div class="star-ratings-top" style="width:'.$g_rates.'px"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>';
               echo '<div class="star-ratings-bottom"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div></div></div>';
               echo '<div class="carousel-info">';

               echo '<img alt="" src="'.$res['gravatar'].'" class="pull-left">';

               echo '<div class="pull-left">';
               echo '<span class="testimonials-name">'.$res['name'].'</span>';
               echo '<span class="testimonials-time">'.$res['country'].'</span>';
               echo '<span class="testimonials-post">'.$res['timestamp'].'</span>';
               echo '<span class="testimonials-post"><i class="fa fa-heart recommends" aria-hidden="true"></i> '.$res['name'].' recommends this hotel</span></div></div>';

               if(isset($res['answer'])&&!empty($res['answer'])&& empty(get_option("answersoff"))){
                  echo "<p><i class='fa fa-comments revanswer' aria-hidden='true'></i>".$obj['property']." answered: ".$res['answer']."</p>";
               }

               echo "</div> \n </div> \n </div> \n </div>";
            $counter++;
            }
        }
    }
}

add_shortcode('chartsbeds-review-page', 'review_add_shortcode');
<?php
function cbreview_widget_shortcode($atts) {
    $cba = shortcode_atts( array(
        'limit' => esc_attr($cba['limit']),
    ), $atts );

    if(empty($cba['limit'])){
        $cba['limit'] = 4;
    }

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
                                echo '<div class="media-left"><img src="'.$res['gravatar'].'" class="img-circle" width="60px"></div>';
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

                echo '<a href="#" class="btn btn-primary">Go to reviews page</a>';
                echo '</ul></div></div>';

   //End comments Widget
}

add_shortcode('chartsbeds-review-recent', 'cbreview_widget_shortcode');
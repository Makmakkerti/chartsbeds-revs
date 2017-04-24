<?php

/// Function ADD Reviews to the page
function review_add_shortcode($cbh) {
    $cbh = shortcode_atts( array(
        'limit' => esc_attr($cbh['limit']),
    ), $atts );

    $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'&limit='.esc_attr($cbh['limit']).'');
    $obj = json_decode($json, true);

    foreach ($obj as $title => $data){
        $counter = 1;
        foreach($data as $q=>$res) {
            if(is_array($res)){?>
                <div class="row tinline" >
                <?php if ($counter%2 == 0): ?>
                <div class="col-md-5  rcustomers">
                <?php else: ?>
                <div class="col-md-5  rcustomers">
            <?php endif ?>

                <script type="application/javascript">

                    // change this to adjust the rating display
                    var bvTireRating = <?php echo $res['guest_rating']/20;?>;
                    // multiply by 20 to get percentage
                    var starRating = bvTireRating*20;
                    // set the width of the stars
                    JQuery('.star-ratings-top').width(starRating+'%');
                </script>

                <div class="testimonials">
                    <div class="active item">
                        <blockquote><p class="cb-rev-clients"><?php echo $res['review'];?></p></blockquote>

                        <div class="testimonials-rate col-md-4">Rating: <?php echo $res['guest_rating'];?>
                            <div class="star-ratings">
                                <div class="star-ratings-top" style="width:<?php echo $res['guest_rating']*0.65 ;?>px"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                <div class="star-ratings-bottom"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>
                            </div>
                        </div>

                        <div class="carousel-info">
                            <img alt="" src="<?php echo $res['gravatar'];?>" class="pull-left">
                            <div class="pull-left">
                                <span class="testimonials-name"><?php echo $res['name'];?></span>
                                <span class="testimonials-time"><?php echo $res['country'];?></span>
                                <span class="testimonials-post"><?php echo $res['timestamp'];?></span>
                                <span class="testimonials-post"><i class="fa fa-heart recommends" aria-hidden="true"></i> <?php echo $res['name'];?> recommends this hotel</span>
                            </div>
                        </div>
                        <?php
                        if(isset($res['answer'])&&!empty($res['answer'])&& empty(get_option("answersoff"))){
                            echo "<p'><i class='fa fa-comments revanswer' aria-hidden='true'></i>".$obj['property']." answered: ".$res['answer']."</p>";
                        }?>
                    </div>
                </div>
                </div>
                </div>
                <?php
                $counter++;
            }
        }
    }
}

add_shortcode('chartsbeds-review-page', 'review_add_shortcode');
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
    );?>

    <script src="/wp-content/plugins/chartsbeds-review/scripts/circles.js"></script>
    <style>
        <?php $countsV = 1; foreach($arrPercent as $key=>$vals){?>
        #circles-<?php echo $countsV;?>:after{
            content: " <?php echo $key;?>";
            font-size: 16px;
            position: relative;
            display: block;
        }
        <?php $countsV++; }?>
    </style>

    <div id="canvas">
        <div class="wrap_circle"><div class="circle" id="circles-1">cleanliness</div></div>
        <div class="wrap_circle"><div class="circle" id="circles-2">location</div></div>
        <div class="wrap_circle"><div class="circle" id="circles-3">staff</div></div>
        <div class="wrap_circle"><div class="circle" id="circles-4">rooms</div></div>
        <div class="wrap_circle"><div class="circle" id="circles-5">fun</div></div>
    </div>


    <script>
        var colors = [
                ['#D3B6C6', '#4B253A'], ['#FCE6A4', '#EFB917'], ['#BEE3F7', '#45AEEA'], ['#F8F9B6', '#D2D558'], ['#F4BCBF', '#D43A43']
            ],
            circles = [];
        <?php

        $i = 1;
        foreach($arrPercent as $k=>$v){?>

        var child = document.getElementById('circles-<?php echo $i;?>'),
            percentage = <?php echo $v*20;?>,

            circle = Circles.create({
                id:         child.id,
                value:      percentage,
                radius:     getWidth(),
                width:      10,
                colors:     colors[<?php echo $i?> - 1],
                duration:            900,
            });

        <?php $i++; }?>
        circles.push(circle);


        window.onresize = function(e) {
            for (var i = 0; i < circles.length; i++) {
                circles[i].updateRadius(getWidth());
            }
        };

        function getWidth() {
            return window.innerWidth /25;
        }

    </script>


<?php }

add_shortcode('chartsbeds-review-circle', 'rev_creation');
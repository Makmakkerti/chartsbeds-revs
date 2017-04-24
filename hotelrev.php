<?php
/*
* Plugin Name: Chartsbeds
* Description: Chartsbeds reviews plugin.
* Version: 1.0
* Author: ChartsBeds
* Author URI: https://chartsbeds.com
*/
	add_action( 'widgets_init', 'cbbar_widget' );

	function cbbar_widget() {
		register_widget( 'CBbar_Widget' );
	}

	class CBbar_Widget extends WP_Widget {

		function CBbar_Widget() {
			$widget_ops = array( 'classname' => 'wreviews', 'description' => __('A widget that displays hotels review', 'wreviews') );
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wreviews-widget' );
			
			$this->WP_Widget( 'wreviews-widget', __('Chartsbeds review bar', 'wreviews'), $widget_ops, $control_ops );
			
		}
	
			function widget( $args, $instance ) {
				extract( $args );

				//Our variables from the widget settings.
				$title = apply_filters('widget_title', $instance['title'] );
				$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;

				echo $before_widget."<div class='cb-widget'>";

				// Display the widget title 
				if ( $title ){
					echo $before_title . $title . $after_title;
				}

				// Use shortcode in a PHP file (outside the post editor).
				echo do_shortcode( '[chartsbeds-review-bar]' );
				
				echo $after_widget."</div>";
			}

		//Update the widget 
		 
			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;

				//Strip tags from title and name to remove HTML 
				$instance['title'] = strip_tags( $new_instance['title'] );
				$instance['show_info'] = $new_instance['show_info'];

				return $instance;
			}

			
			function form( $instance ) {

				//Set up some default widget settings.
				$defaults = array( 'title' => __('Hotel name', 'wreviews'), 'name' => __('ChartsBeds', 'wreviews'), 'show_info' => true );
				$instance = wp_parse_args( (array) $instance, $defaults ); ?>

				<!-- Widget Title: Text Input.-->
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wreviews'); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>

				
			<?php
			}
		}?><?php
/*The BEGINNING of adding review widget**/

	add_action( 'widgets_init', 'cbreviews_widget' );

	function cbreviews_widget() {
		register_widget( 'CBreviews_Widget' );
	}

	class CBreviews_Widget extends WP_Widget {

			function CBreviews_Widget() {
				$widget_ops = array( 'classname' => 'reviews', 'description' => __('A widget that displays hotels review', 'reviews') );
				
				$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'reviews-widget' );
				
				$this->WP_Widget( 'reviews-widget', __('Chartsbeds review recent', 'reviews'), $widget_ops, $control_ops );
				
			}
	
			function widget( $args, $instance ) {
				extract( $args );

				//Our variables from the widget settings.
				$title = apply_filters('widget_title', $instance['title'] );
				$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;

				echo $before_widget."<div class='cb-widget'>";

				// Display the widget title 
				if ( $title ){
					echo $before_title . $title . $after_title;
				}

				// Use shortcode in a PHP file (outside the post editor).
				echo do_shortcode( '[chartsbeds-review-recent]' );
				
				echo $after_widget."</div>";
			}

	//Update the widget 
	 
			function update( $new_instance, $old_instance ) {
				$instance = $old_instance;

				//Strip tags from title and name to remove HTML 
				$instance['title'] = strip_tags( $new_instance['title'] );
				$instance['show_info'] = $new_instance['show_info'];

				return $instance;
			}

	
			function form( $instance ) {

				//Set up some default widget settings.
				$defaults = array( 'title' => __('Hotel name', 'reviews'), 'name' => __('ChartsBeds', 'reviews'), 'show_info' => true );
				$instance = wp_parse_args( (array) $instance, $defaults ); ?>

				<!-- Widget Title: Text Input.-->
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'reviews'); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>

				
			<?php
			}
		}
/*The end of adding review widget**/
?><?php 
	
/*Adding settings page to Admin Panel*/
		function charts_admin() {
			include('chartsbeds_admin.php');
		}
		 
		function charts_admin_actions() {
			add_menu_page("Chartsbeds", "Chartsbeds", 1, "Chartsbeds", "charts_admin", "/wp-content/plugins/chartsbeds-review/chartsbeds_ico.png", 7);
			//( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		}
		 
		add_action('admin_menu', 'charts_admin_actions');

/******Circles REVIEWS*/
				
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


		<link rel='stylesheet' href='/wp-content/plugins/chartsbeds-review/styles/style.css' type='text/css' media='all' />
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
			
			.wrap_circle{
				width: 16%;
				text-align: center;
				float: left;
				margin-left: 1em;
				margin-top: 40px;
				margin-bottom: 20px;
			}
			
			#canvas{
				left: 3%;
				position: relative;
			}
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


<?php }?>

<?php add_shortcode('chartsbeds-review-circle', 'rev_creation');?>


<?php
/*Widget Reviews Progressbar*/			
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
					);?>


<html>
	<head>
	<style>
			.progress-1 {
			background-color: #4B253A;
		}

		.progress-2 {
			background-color: #EFB917;
		}

		.progress-3 {
			background-color: #45AEEA;
		}

		.progress-4 {
			background-color: #D2D558;
		}

		.progress-5 {
			background-color: #D43A43;
		}
	</style>
		<link rel='stylesheet' href='/wp-content/plugins/chartsbeds-review/styles/style.css' type='text/css' media='all' />
		<script type="text/javascript" src="https://viralpatel.net/blogs/demo/jquery/jquery.shorten.1.0.js"></script>
		
		<script>
			 jQuery(document).ready(function() {
				 				 
				  jQuery('.progress .progress-bar').css("width",
							function() {
								return jQuery(this).attr("aria-valuenow") + "%";
							}
					);
					
				  jQuery(".charts-widg-p").shorten({
				    "showChars" : 100,
					"moreText"	: " See More",
				    "lessText"	: " Less",}
				  );
				  
				  jQuery(".cb-rev-clients").shorten({
				    "showChars" : 240,
					"moreText"	: " See More",
				    "lessText"	: " Less",
					}
				  );
					jQuery(".morecontent a").addClass("btn btn-default btn-xs");
					
					jQuery(".morelink").click(function(){
						if (jQuery(this).closest( '.rcustomers' ).hasClass( "col-md-10" )){jQuery(this).closest( '.rcustomers' ).removeClass( 'col-md-10' )}else{jQuery(this).closest( '.rcustomers' ).addClass( 'col-md-10' )};
					});
					
			}); 
				  
		</script>
			
				
	</head>
	
    <body>
	
			 <!-- Skill Bars -->
			 <?php 
						
						$pl = 1;
						foreach($arrPercent as $k=>$v){	?>
						
					<div class="progress skill-bar ">
						<div class="progress-bar progress-<?php echo $pl;?> progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $v*20;?>" aria-valuemin="0" aria-valuemax="100">
							<span class="skill"><?php echo $k;?><i class="val"><?php echo $v*20;?></i></span>
						</div>
					</div>
						<?php $pl++; }?>		
					
			<!--/div>
		</div-->
    </body>
</html>

<?php }?>

<?php add_shortcode('chartsbeds-review-bar', 'widget_bar_creation');?>


<?php
	// Function ADD Reviews to the page
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
												$('.star-ratings-top').width(starRating+'%');
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
		
function cbreview_widget_shortcode($atts) {
	$cba = shortcode_atts( array(
        'limit' => esc_attr($cba['limit']),
    ), $atts );
	
	if(empty($cba['limit'])){
		$cba['limit'] = 4;
	}
	
	
	?>

		<!--Start comments Widget -->
		<head>
		<style>
			.cwheader{
				background-color: #537cb4 !important;
			}
			
			.cwheader h3{
					color: #fff !important;
			}
			.media-heading{
				line-height: 18px;
			}
			.charts-widg{
				float: right;
				padding-right: 10px;
				line-height: 12px;
				margin-top: 5px;
				padding: 0px;
			}
			.media-left{
				float: left;
				width: 20%;
				margin-right: 10px;
				<?php if(!empty(get_option("gravataroff"))) echo "display:none;";?>
			}
			.revdate{
				float: right;
				font-size: 11px;
			}
			.charts-widg-p{
				margin: 0;
				line-height: 14px;
				font-size: 12px;
				font-family: arial;
			}
		</style>
	</head>
	
	<body>
		
                    <!-- Fluid width widget -->        
    	    <div class="panel panel-default">
                <!--div class="panel-heading cwheader">
                    <h3 class="panel-title">
                        <span class="fa fa-comments-o"></span> 
                        Recent reviews
                    </h3>
                </div-->
                <div class="panel-body">
                    <ul class="media-list">
						<?php $json = file_get_contents('http://dashboard.chartspms.com/REVIEWS.json.php?apiKey='.get_option("charts_key").'&limit='.esc_attr($cba['limit']).'');
						$obj = json_decode($json, true);

						foreach ($obj as $title => $data){
							$counter = 1;
							foreach($data as $q=>$res) {
								if(is_array($res)){?>
                        <li class="media">
                            <div class="media-left">
                                <img src="<?php echo $res['gravatar'];?>" class="img-circle" width="60px">
                            </div>
                            <div class="media-body">
							<span class="revdate"><?php echo $res['timestamp'];?></span>
                                <h4 class="media-heading">
                                    <small><b><?php echo ucfirst($res['name']);?></b> <br />from <?php echo $res['country'];?></small><br><small><span class="fa fa-thumbs-up" style="color:#337ab7"></span> <?php echo $res['guest_rating'];?>% Satisfied <br>
									</small>
                                </h4>
                                <p class="charts-widg-p">
                                    <?php echo $res['review'];?>
                                </p>
								<p class="charts-widg" ><small><span class="fa fa-heart" style="color:red"></span> <?php echo ucfirst($res['name']);?> recommends this hotel</small></p>
                            </div>
                        </li>
						
						<hr>
                        <?php }}}?>
                    <a href="#" class="btn btn-primary">Go to reviews page»</a>
                    </ul>
                </div>
            </div>
            <!-- End fluid width widget --> 
			
    	</body>			
<!--End comments Widget -->
<?php }
	add_shortcode('chartsbeds-review-recent', 'cbreview_widget_shortcode');

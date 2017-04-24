<?php
if($_POST['charts_hidden'] == 'Y') {
        //Form data sent
		 $apiKey = $_POST['charts_key'];
		 update_option('charts_key', $apiKey);
		 
             if(!empty($_POST['gravataroff'])){
                 $gravoff = "checked";
             }else{
                 $gravoff = "";
             }
             update_option('gravataroff', $gravoff);

             if(!empty($_POST['answersoff'])){
                 $gravoff = "checked";
             }else{
                 $gravoff = "";
             }
             update_option('answersoff', $gravoff);
		 
		 ?>
		 
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php
}else{
	$apiKey = get_option('charts_key');
}
?>

<div class="wrap">
    <?php    echo "<h2>" . __( 'ChartsBeds Options', 'charts_updates' ) . "</h2>"; ?>
     
    <form name="charts_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="charts_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Chartsbeds API KEY', 'charts_updates' ) . "</h4>"; ?>
		
        <p><?php _e("Insert API KEY: " ); ?>
		<input type="text" name="charts_key" value="<?php echo $apiKey; ?>" size="110"><?php _e(" to recieve KEY, please contact Chartbeds support" ); ?>
		</p>
                
		<div>
			<input type="checkbox" id="gravataroff" name="gravataroff" value="checking" <?php echo get_option("gravataroff"); ?>>
			<label for="gravataroff">Check to disable gravatars for reviews widget</label>
		</div>
		
		<div>
			<input type="checkbox" id="answersoff" name="answersoff" value="answersoff" <?php echo get_option("answersoff"); ?>>
			<label for="answersoff">Check to disable hotel's answer for reviews</label>
		</div>
		
        <p class="submit">
        <input type="submit" name="Save" value="<?php _e('Update Options', 'charts_updates' ) ?>" />
        </p>
    </form>
</div>




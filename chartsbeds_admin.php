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
		 
             echo '<div class="updated"><p><strong>';
             _e('Options saved.' );
             echo '</strong></p></div>';

}else{
	$apiKey = get_option('charts_key');
}


echo '<div class="wrap">';
echo "<h2>" . __( 'ChartsBeds Options', 'charts_updates' ) . "</h2>";
echo '<form name="charts_form" method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';
echo '<input type="hidden" name="charts_hidden" value="Y">';
echo "<h4>" . __( 'Chartsbeds API KEY', 'charts_updates' ) . "</h4>";
echo '<p>';
_e("Insert API KEY: " );
echo '<input type="text" name="charts_key" value="'.$apiKey.'" size="110">';
echo '<label for="male">';
_e(" to recieve KEY, please contact Chartsbeds support" );
echo '</label></p>';
echo '<div>';
echo '<input type="checkbox" id="gravataroff" name="gravataroff" value="checking" '.get_option("gravataroff").'>';
echo '<label for="gravataroff">Check to disable gravatars for reviews widget</label></div>';
echo '<div><input type="checkbox" id="answersoff" name="answersoff" value="answersoff" '.get_option("answersoff").'';
echo '<label for="answersoff">Check to disable hotel\'s answer for reviews</label></div>';
echo '<p class="submit"><input type="submit" name="Save" value="';
_e('Update Options', 'charts_updates' );
echo '" /></p></form></div>';
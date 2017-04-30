<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( !current_user_can('edit_others_pages') ) {echo "You have no permission to edit this page"; exit;}  // Exit if user have no permissions to edit site

$submitted_value = $_REQUEST['_wpnonce'];

if($GET['action']= 'update' && wp_verify_nonce($submitted_value, 'cbeds-update')) {
        //Form data sent
		 $apiKey = esc_html($_POST['charts_key']);
		 update_option('charts_key', $apiKey);

         $urlRev = esc_url_raw(esc_html($_POST['rev_url']));
         update_option('rev_url', $urlRev);

        $recAmt = intval($_POST['rec_amt']);
        update_option('rec_amt', $recAmt);
		 
             if(!empty($_POST['gravataroff'])){
                 $gravoff = "checked";
             }else{
                 $gravoff = "";
             }
             update_option('gravataroff', $gravoff);

             if(!empty($_POST['answers_off'])){
                 $answeroff = "checked";
             }else{
                 $answeroff = "";
             }
             update_option('answers_off', $answeroff);

            if(!empty($_POST['thanks_on'])){
                $thanks_on = "checked";
            }else{
                $thanks_on = "";
            }
            update_option('thanks_on', $thanks_on);

             echo '<div class="updated"><p><strong>';
             _e('Options saved.' );
             echo '</strong></p></div>';

}else{
	$apiKey = get_option('charts_key');
    $urlRev = get_option('rev_url');
    $recAmt = get_option('rec_amt');
}

echo '<div class="wrap">';
echo "<h2>" . __( 'ChartsBeds Options', 'charts_updates' ) . "</h2>";
echo '<form name="charts_form" method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'&action=update">';
/*echo '<input type="hidden" name="charts_hidden" value="Y">';*/

echo "<h4>" . __( 'Chartsbeds API KEY', 'charts_updates' ) . "</h4>";
echo '<p>';
_e("Insert API KEY: " );
echo '<input type="text" name="charts_key" id="charts_key" value="'.$apiKey.'" size="110">';
echo '<label for="charts_key">';
_e(" to recieve KEY, please contact Chartsbeds support" );
echo '</label></p>';

echo '<p>';
_e("Insert Reviews page url (optional):" );
echo '<input type="text" name="rev_url" id="rev_url" value="'.$urlRev.'" size="110">';
echo '</p>';

echo '<p>';
_e("Recent reviews widget, choose amount to show:" );
echo '<input type="number" name="rec_amt" id="rec_amt" name="quantity" value="'.$recAmt.'" min="1" max="8">';
echo '</p>';

echo '<div>';
echo '<input type="checkbox" id="gravataroff" name="gravataroff" value="checking" '.get_option("gravataroff").'>';
echo '<label for="gravataroff">Check to disable gravatars for reviews widget</label></div>';

echo '<div>';
echo '<input type="checkbox" id="answers_off" name="answers_off" value="check" '.get_option("answers_off").'>';
echo '<label for="answers_off">Check to disable hotel\'s answer for reviews</label></div>';

echo '<div>';
echo '<input type="checkbox" id="thanks_on" name="thanks_on" value="check" '.get_option("thanks_on").'>';
echo '<label for="thanks_on">Check to enable Chartsbeds link in reviews</label></div>';

echo '<p class="submit"><input type="submit" name="Save" value="';
_e('Update Options', 'charts_updates' );
echo '" /></p>';
wp_nonce_field('cbeds-update');
echo '</form></div>';

echo '<a href="http://www.chartsbeds.com/" target="_blank"><img src="'.plugins_url().'/chartsbeds-review/img/chartsbeds-web-logo.png" width="150px"></a>';
echo '<a href="http://dashboard.chartspms.com/" target="_blank"><img src="'.plugins_url().'/chartsbeds-review/img/review-logo.png" width="200px"></a>';

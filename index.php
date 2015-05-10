<?php
/*
Plugin Name: Disable user modify profile page
Description: Go to "Settings->Profile Access", and Disable users, to access(modify) his profile page.  (P.S.  OTHER MUST-HAVE PLUGINS FOR EVERYONE: http://bitly.com/MWPLUGINS  )
contributors: selnomeria,giuseppemazzapica, 
Original Author: ( Based on https://gist.github.com/Giuseppe-Mazzapica/11070063 and http://wordpress.stackexchange.com/a/29087 )
@license free
Version: 1.1
*/
if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

add_action( 'admin_init', 'stop_access_profile__DUMPD'); function stop_access_profile__DUMPD() {
	if(!current_user_can( 'create_users')){
		if (get_option('AllOrInd__DUMPP') == 'all') {	$disabled =true;	}
		if (get_option('AllOrInd__DUMPP') != 'all') {	$ids = explode( ',', get_option('DisabledIds__DUMPP'));
			if ($GLOBALS['current_user']->ID == 0 || in_array( $GLOBALS['current_user']->ID, $ids)){  $disabled =true;  }
		}
					if (isset($disabled)) { ///////////////START DISABLINGG/////////////////
		remove_menu_page('profile.php');	remove_submenu_page( 'users.php', 'profile.php' );
		if( (defined( 'IS_PROFILE_PAGE' ) && IS_PROFILE_PAGE && IS_PROFILE_PAGE === true)) {
			wp_redirect( admin_url() );	wp_die( 'You are not permitted to change your own profile information. Please contact a member of HR to have your profile information changed. <a href="'.admin_url() .'">Dashboard url</a>' );
}}}}

//add_action('wp_before_admin_bar_render', 'remove_adminbar_completely__DUMPD' ); function remove_adminbar_completely__DUMPD(){
//	if (!current_user_can( 'create_users' )) {  //&& 'wp_before_admin_bar_render' === current_filter()
//		return $GLOBALS['wp_admin_bar']->remove_menu( 'edit-profile', 'user-actions' );}}


//==================================================== ACTIVATION command ===============================
register_activation_hook( __FILE__, 'activation__DUMPP' );function activation__DUMPP() {if (!get_option('AllOrInd__DUMPP')) {
		update_option('AllOrInd__DUMPP',	'all');	update_option('DisabledIds__DUMPP',	'0,99999998,99999999');	}}
add_action( 'activated_plugin', 'activat_redirect__DUMPP' ); function activat_redirect__DUMPP( $plugin ) { 
    if( $plugin == plugin_basename( __FILE__ ) ) {  exit(wp_redirect( admin_url( 'admin.php?page=my-disable-userprof-access')) );  }
}


//==================================================== ADMIN DASHBOARD PAGE  ===============================
// START 
if ( is_admin() ){	add_action('admin_menu', 'exec_pages__DUMPP'); function exec_pages__DUMPP() { add_submenu_page('options-general.php', 'Disable Profile Access', 'Disable Profile Access','create_users', 'my-disable-userprof-access',  'my_submenu1__DUMPP');
	}
	function my_submenu1__DUMPP() { 
		if (isset($_POST['inp_SecureNonce'])){	if(wp_verify_nonce($_POST['inp_SecureNonce'],'fupd__DUMPP')) { 
			update_option('AllOrInd__DUMPP',$_POST['AllOrInd']);	update_option('DisabledIds__DUMPP',	$_POST['disabledIds']);
		}}	$chosen_method = get_option('AllOrInd__DUMPP');
	?> 
	<form action="" method="POST"><h1>==profile page access==</h1>	<br/>Disable for everyone(except admins): <input type="radio" name="AllOrInd" value="all" <?php echo (($chosen_method=='all')? 'checked="checked"':'');?> />
	<br/>Disable them individually : <input type="radio" name="AllOrInd" value="individual" <?php echo (($chosen_method=='individual')? 'checked="checked"':'');?> /> (if this checkbox is chosen, then input user IDs here, separated with comma: <input type="text" style="width:90%;" name="disabledIds" value="<?php echo get_option('DisabledIds__DUMPP');?>" /> 
	<br/><br/><input type="submit" value="SAVE" /><input type="hidden" name="inp_SecureNonce" value="<?php echo wp_create_nonce('fupd__DUMPP');?>" /></form>
	<?php }} ?>
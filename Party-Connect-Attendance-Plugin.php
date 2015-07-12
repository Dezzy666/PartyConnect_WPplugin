<?php
/*
Plugin Name: Party Connect Attendance

*/

/******************************************************************************/
/*        Final variables                                                     */
/******************************************************************************/
define('PLUGIN_PREFIX', 'party_connect_plugin');
define('PLUGIN_JAVASCRIPT_NAME', 'party_connect_plugin_script');
define('PLUGIN_JAVASCRIPT_PARAMS', 'party_connect_plugin_params');
define('OPTION_NAME_ALL_GUESTS', 'party_connect_plugin_all_guests');
define('OPTION_NAME_DROPDOWN_MENU', 'party_connect_plugin_dropdown_menu');
define('MENU_UNIQUE_ID', 'party_connect_plugin_menu');
define('PLUGIN_SETTINGS_PREFIX', 'party_connect_plugin_settings');

/******************************************************************************/
/*        Functions                                                           */
/******************************************************************************/

/**
 * Runs after the plugin is activated.
 *
 * @method partyConnect_registerActivationHook
 * @author Jan Herzan
 */
function partyConnect_registerActivationHook() {
    add_option(OPTION_NAME_DROPDOWN_MENU, []);
    add_option(OPTION_NAME_ALL_GUESTS, []);
}

/**
 * Runs after the plugin is uninstaled.
 *
 * @method partyConnect_registerUninstallHook
 * @author Jan Herzan
 */
function partyConnect_registerUninstallHook() {

}

/**
 * Creates shortcode for attendance creation.
 * Shortcode: [PARTY_CONNECT_ATTENDANCE]
 *
 * @method partyConnect_attendanceCreation
 * @author Jan Herzan
 */
function partyConnect_attendanceCreation($atts){
	return "Here will be the attendance form";
}

/**
 * Adds attendance options into menu.
 *
 * @method partyConnect_addPluginMenu
 * @author Jan Herzan
 */
function partyConnect_addPluginMenu() {
	add_options_page('Party connect attendance', 'Attendance options', 'manage_options', $MENU_UNIQUE_ID, 'partyConnect_pluginOptions');
}

/**
 * Generates menu options page.
 *
 * @method partyConnect_pluginOptions
 * @author Jan Herzan
 */
function partyConnect_pluginOptions() {
	if (!current_user_can( 'manage_options'))  {
		wp_die(__( 'You do not have sufficient permissions to access this page.'));
	}

  $dropDownMenu = get_option(OPTION_NAME_DROPDOWN_MENU);
  $guests = get_option(OPTION_NAME_ALL_GUESTS);

  include "Party-Connect-Options-Menu.php";
}

/**
 * Processes data from user (using ajax).
 *
 * @method partyConnect_ajax_saveUserData
 * @author Jan Herzan
 * @param {Object} Data from client
 * @return {String} Data to return
 */
function partyConnect_ajax_saveUserData($data) {
   echo "Response";
   die();
}

/**
 * Process data from admin (using ajax);
 *
 * @method partyConnect_ajax_saveAdminSettings
 */
function partyConnect_ajax_saveNewPerson() {
   if (isset($_POST['name']) && isset($_POST['dropdownMenu'])) {
      $guests = get_option(OPTION_NAME_ALL_GUESTS);
      array_push($guests, sizeof($guests), array(
        "name" => $_POST['name'], "dropdownMenu" => $_POST['dropdownMenu'], "state" => 0
      ));

      update_option(OPTION_NAME_ALL_GUESTS, $guests);
      echo "Saved";
   } else {
      echo "Bad data";
   }
   die();
}

/**
 * Adds scripts to pages.
 *
 * @method partyConnect_addLibsToPages
 * @author Jan Herzan
 */
function partyConnect_addScriptsToPages() {
          // Adds JS library
         wp_register_script(PLUGIN_JAVASCRIPT_NAME, plugins_url('/js/partyConnect_core.js', __FILE__), array('jquery'));

        // Get the protocol of the current page
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

        $params = array(
            'ajaxurl' => admin_url('admin-ajax.php', $protocol),
        );
        wp_localize_script(PLUGIN_JAVASCRIPT_NAME, PLUGIN_JAVASCRIPT_PARAMS, $params);
        wp_enqueue_script(PLUGIN_JAVASCRIPT_NAME);
}

/******************************************************************************/
/*        Executive code                                                      */
/******************************************************************************/
register_activation_hook( __FILE__, 'partyConnect_registerActivationHook' );
add_shortcode('PARTY_CONNECT_ATTENDANCE','partyConnect_attendanceCreation');
add_action('admin_menu','partyConnect_addPluginMenu');
add_action('wp_ajax_partyConnect_ajax_saveNewPerson', 'partyConnect_ajax_saveNewPerson');
add_action('wp_ajax_partyConnect_ajax_saveUserData', 'partyConnect_ajax_saveUserData');
add_action('wp_ajax_nopriv_partyConnect_ajax_saveUserData', 'partyConnect_ajax_saveUserData');
add_action('wp_enqueue_scripts','partyConnect_addScriptsToPages');
add_action('admin_enqueue_scripts', 'partyConnect_addScriptsToPages' );

?>

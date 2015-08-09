<?php
/*
Plugin Name: Party Connect Attendance
Plugin URI:  http://jan.herzan.eu/subdom/jan/party-connect-attendance/
Description: Simple plugin for attendance. There is no registration necessary for guests.
Version:     1.0
Author:      Jan Herzan
Author URI:  http://jan.herzan.eu
License:     Apache License Version 2.0
License URI: http://www.apache.org/licenses/
Domain Path: /lang
Text Domain: Party-Connect-Attendance-Plugin
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
define('DROPDOWNMENU_BANNED_VALUE', '$party_connect_deleted$');

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
 * Runs after the plugin is deactivated.
 *
 * @method partyConnect_registerDeactivationHook
 * @author Jan Herzan
 */
function partyConnect_registerDeactivationHook() {
   update_option(OPTION_NAME_ALL_GUESTS, []);
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
  $dropDownMenu = get_option(OPTION_NAME_DROPDOWN_MENU);
  $dropDownMenuNumber = get_option(OPTION_NAME_DROPDOWN_MENU_LAST_INDEX);
  $guests = get_option(OPTION_NAME_ALL_GUESTS);
  $guestsNumber = get_option(OPTION_NAME_ALL_GUESTS_LAST_INDEX);

  include "Party-Connect-Attendance-Table-Creation.php";
}

/**
 * Adds attendance options into menu.
 *
 * @method partyConnect_addPluginMenu
 * @author Jan Herzan
 */
function partyConnect_addPluginMenu() {
	add_options_page('Party connect attendance', __('Attendance options', PLUGIN_PREFIX), 'manage_options', $MENU_UNIQUE_ID, 'partyConnect_pluginOptions');
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
   try {
      $id = intval($_POST['id']);
      $state = intval($_POST['state']);
      $dropdownMenu = intval($_POST['dropdownMenu']);
   } catch (Exception $e) {
      echo "Invalid numbers";
      die();
   }

   $guests = get_option(OPTION_NAME_ALL_GUESTS);
   if (($state == 1 || $state == 2) && $state != 3) {
      $guests[$id]["state"] = $state;
   }

   $guests[$id]["dropdownMenuValue"] = $dropdownMenu;

   update_option(OPTION_NAME_ALL_GUESTS, $guests);
   echo "Saved";
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
      array_push($guests, array(
        "name" => $_POST['name'], "dropdownMenu" => $_POST['dropdownMenu'], "state" => 0, "dropdownMenuValue" => 0
      ));

      update_option(OPTION_NAME_ALL_GUESTS, $guests);
      echo "Saved";
   } else {
      echo "Bad data";
   }
   die();
}

/**
 * Deltes person. (using ajax);
 *
 * @method partyConnect_ajax_deletePerson
 */
function partyConnect_ajax_deletePerson() {
   $guests = get_option(OPTION_NAME_ALL_GUESTS);
   if (isset($_POST['id']) && $_POST['id'] < sizeof($guests)) {
      $guests[$_POST['id']]["state"] = 3;
      update_option(OPTION_NAME_ALL_GUESTS, $guests);
      echo "Deleted";
   } else {
      echo "Bad data";
   }
   die();
}

/**
 * Adds new dropdown menu option
 *
 * @method partyConnect_ajax_addDropdownMenuOption
 * @author Jan Herzan
 */
function partyConnect_ajax_addDropdownMenuOption() {
   $dropDownMenu = get_option(OPTION_NAME_DROPDOWN_MENU);

   if ($_POST['item'] == DROPDOWNMENU_BANNED_VALUE) {
      echo "Bad data";
      die();
   }

   array_push($dropDownMenu, $_POST['item']);

   update_option(OPTION_NAME_DROPDOWN_MENU, $dropDownMenu);
   echo "Saved";
   die();
}

/**
 * Deletes dropdown menu option
 *
 * @method partyConnect_ajax_deleteDropdownMenuOption
 * @author Jan Herzan
 */
function partyConnect_ajax_deleteDropdownMenuOption() {
    try {
      $id = intval($_POST['id']);
    } catch (Exception $e) {
      echo "Invalid numbers";
      die();
   }

   $dropDownMenu = get_option(OPTION_NAME_DROPDOWN_MENU);

   if ($id < sizeof($dropDownMenu)) {
      $dropDownMenu[$id] = DROPDOWNMENU_BANNED_VALUE;
   } else {
      echo "Bad data";
      die();
   }

   update_option(OPTION_NAME_DROPDOWN_MENU, $dropDownMenu);
   echo "Saved";
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

     // Adds stylesheet
     wp_register_style(PLUGIN_JAVASCRIPT_NAME,  plugins_url('/styles/partyConnect_styles.css', __FILE__));

    // Get the protocol of the current page
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

    $params = array(
        'ajaxurl' => admin_url('admin-ajax.php', $protocol),
    );
    wp_localize_script(PLUGIN_JAVASCRIPT_NAME, PLUGIN_JAVASCRIPT_PARAMS, $params);
    wp_enqueue_script(PLUGIN_JAVASCRIPT_NAME);
    wp_enqueue_style(PLUGIN_JAVASCRIPT_NAME);
}

/**
 * Inserts localization files.
 *
 * @method partyConnect_languageSetup
 * @author Jan Herzan
 */
function partyConnect_languageSetup() {
   load_plugin_textdomain(PLUGIN_PREFIX, false, dirname(plugin_basename(__FILE__)) . '/lang');
}
/******************************************************************************/
/*        Executive code                                                      */
/******************************************************************************/

// De-Activation Hooks
register_activation_hook( __FILE__, 'partyConnect_registerActivationHook' );
register_deactivation_hook(__FILE__, 'partyConnect_registerDeactivationHook');

// Plugin loading
add_action( 'plugins_loaded', 'partyConnect_languageSetup' );

// Add shortcode
add_shortcode('PARTY_CONNECT_ATTENDANCE','partyConnect_attendanceCreation');

// Add menu option
add_action('admin_menu','partyConnect_addPluginMenu');
add_action('admin_init', 'partyConnect_registerSettings');

// Ajax methods secured
add_action('wp_ajax_partyConnect_ajax_saveNewPerson', 'partyConnect_ajax_saveNewPerson');
add_action('wp_ajax_partyConnect_ajax_deletePerson', 'partyConnect_ajax_deletePerson');
add_action('wp_ajax_partyConnect_ajax_saveUserData', 'partyConnect_ajax_saveUserData');
add_action('wp_ajax_partyConnect_ajax_addDropdownMenuOption', 'partyConnect_ajax_addDropdownMenuOption');
add_action('wp_ajax_partyConnect_ajax_deleteDropdownMenuOption', 'partyConnect_ajax_deleteDropdownMenuOption');

// Ajax methods unsecured
add_action('wp_ajax_nopriv_partyConnect_ajax_saveUserData', 'partyConnect_ajax_saveUserData');

// Javascript and CSS loading
add_action('wp_enqueue_scripts','partyConnect_addScriptsToPages');
add_action('admin_enqueue_scripts', 'partyConnect_addScriptsToPages' );

?>

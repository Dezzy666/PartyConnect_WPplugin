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
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

/**
 * This method is ajax handler
 *
 * @method partyConnect_ajaxDataHandler
 * @author Jan Herzan
 * @param {Object} Data from client
 * @return {Object} Data to return
 */
function partyConnect_ajaxDataHandler($data) {
   echo "Response";
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
         wp_register_script(PLUGIN_JAVASCRIPT_NAME, plugins_url('/js/partyConnect_core.js', __FILE__));

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
add_shortcode('PARTY_CONNECT_ATTENDANCE','partyConnect_attendanceCreation');
add_action('admin_menu','partyConnect_addPluginMenu');
add_action('wp_ajax_partyConnect_ajaxDataHandler', 'partyConnect_ajaxDataHandler');
add_action('wp_ajax_nopriv_partyConnect_ajaxDataHandler', 'partyConnect_ajaxDataHandler');
add_action('wp_enqueue_scripts','partyConnect_addScriptsToPages');

?>

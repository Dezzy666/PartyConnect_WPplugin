
// Creates namespace
if (typeof window.PartyConnect === "undefined") {
    window.PartyConnect = {};
}

/**
* Adds new person.
*
* @method addNewPerson
* @author Jan Herzan
*/
PartyConnect.addNewPerson = function (name, dropdownMenu) {
    var url = party_connect_plugin_params.ajaxurl,
        data = {
          'action': 'partyConnect_ajax_saveNewPerson',
          'name': name,
          'dropdownMenu': (dropdownMenu ? 1 : 0)
        };

	jQuery.post(url, data, function(response) {
		location.reload();
	});
};

/**
 * Updates state of the person.
 *
 * @method updateState
 * @author Jan Herzan
 * @param {Integer} Person identifier
 * @param {function} Callback after success.
 * @param {Integer} New state
 * @param {Integer} Dropdown menu value.
 */
PartyConnect.updateState = function (id, callBack, newState, dropdownMenu) {
   var url = party_connect_plugin_params.ajaxurl,
       data = {
         'action': 'partyConnect_ajax_saveUserData',
         'id': id,
         'state': newState,
         'dropdownMenu': dropdownMenu !== undefined ? dropdownMenu : -1
       };

    jQuery.post(url, data, callBack);
}

/**
 * Deletes preson.
 *
 * @method deletePerson
 * @author Jan Herzan
 * @param {Integer} Person identifier.
 */
PartyConnect.deletePerson = function (id) {
   var url = party_connect_plugin_params.ajaxurl,
      data = {
         'action': 'partyConnect_ajax_deletePerson',
         'id': id
      };
   jQuery.post(url, data, function (response) {
      location.reload();
   });
};

/**
 * Adds dropdown menu item.
 *
 * @method addDropdownMenuItem
 * @author Jan Herzan
 */
PartyConnect.addDropdownMenuItem = function (item) {
   var url = party_connect_plugin_params.ajaxurl,
       data = {
          'action': 'partyConnect_ajax_addDropdownMenuOption',
          'item': item
       };
   jQuery.post(url, data, function (response) {
      location.reload();
   });
};

/**
 * Deletes dropdown menu item.
 *
 * @method deleteDropdownMenuItem
 * @author Jan Herzan
 */
PartyConnect.deleteDropdownMenuItem = function (id) {
   var url = party_connect_plugin_params.ajaxurl,
       data = {
          'action': 'partyConnect_ajax_deleteDropdownMenuOption',
          'id': id
       };
   jQuery.post(url, data, function (response) {
      location.reload();
   });
};

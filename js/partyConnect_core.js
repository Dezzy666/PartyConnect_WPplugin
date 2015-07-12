
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
          'dropdownMenu': dropdownMenu
        };

	jQuery.post(url, data, function(response) {
		location.reload();
	});
};

console.log("loaded");

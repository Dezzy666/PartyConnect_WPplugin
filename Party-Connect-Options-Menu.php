<?php
/******************************************************************************/
/* Expected variables:                                                        */
/* $dropDownMenu                                                              */
/* $guests                                                                    */
/* PLUGIN_PREFIX                                                              */
/* PLUGIN_SETTINGS_PREFIX                                                     */
/******************************************************************************/
?>
<div class="wrap">
  <h2><?php echo __('Settings for Party Connect plugin', PLUGIN_PREFIX); ?></h2>
	<h3><?php echo __('Dropdown menu', PLUGIN_PREFIX); ?></h3>

  <table>
    <thead>
      <tr><td><?php echo __('Item', PLUGIN_PREFIX); ?></td><td><?php echo __('Delete', PLUGIN_PREFIX); ?></td></tr>
    </thead>
    <tbody>
      <?php
        for ($i = 0; $i < sizeof($dropDownMenu); $i++) {
           echo '<tr><td>', $dropDownMenu[$i], '</td><td>✖</td></tr>';
        }
      ?>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <td><?php echo __('Name', PLUGIN_PREFIX); ?></td>
        <td><?php echo __('Has dropdown menu', PLUGIN_PREFIX); ?></td>
        <td><?php echo __('State', PLUGIN_PREFIX); ?></td>
        <td><?php echo __('Drop down menu value', PLUGIN_PREFIX); ?></td>
        <td><?php echo __('Delete', PLUGIN_PREFIX); ?></td>
      </tr>
    </thead>
    <?php
       for ($i = 0; $i < sizeof($guests); $i++) {
          if ($guests[$i]["state"] == 3) {
             continue;
          }

          echo '<tr>';
          echo '<td>',$guests[$i]["name"], '</td>';

          if ($guests[$i]["dropdownMenu"] == 1) {
             echo '<td>',__('Yes', PLUGIN_PREFIX), '</td>';
          } else {
             echo '<td>',__('No', PLUGIN_PREFIX), '</td>';
          }

          if ($guests[$i]["state"] == 1) {
             echo '<td>',__('Accepted', PLUGIN_PREFIX), '</td>';
          } else if ($guests[$i]["state"] == 2) {
             echo '<td>',__('Declined', PLUGIN_PREFIX), '</td>';
          } else {
             echo '<td></td>';
          }

          if ($guests[$i]["dropdownMenuValue"] > -1 && sizeof($dropDownMenu) > $guests[$i]["dropdownMenuValue"]) {
             echo '<td>',$dropDownMenu[$guests[$i]["dropdownMenuValue"]], '</td>';
          } else {
             echo '<td></td>';
          }

          echo '<td class="userDeleting" data-id="', $i, '">✖</td>';
          echo '</tr>';
       }
    ?>
  </table>

  <table>
     <tr><td><?php echo __('Name', PLUGIN_PREFIX); ?></td><td><input id="partyConnectNameInput"></td></tr>
     <tr><td><?php echo __('Allow dropdown menu', PLUGIN_PREFIX); ?></td><td><input id="partyConnectDropdownInput" type="checkbox"></td></tr>
     <tr><td colspan="2"><div class="button button-primary" id="partyConnectAddGuestButton"><?php echo __('Add guest', PLUGIN_PREFIX); ?></div></td></tr>
  </table>

  <script>
     jQuery(function () {
        jQuery("#partyConnectAddGuestButton").on("click", function () {
           PartyConnect.addNewPerson(jQuery("#partyConnectNameInput").val(), jQuery("#partyConnectDropdownInput").attr('checked') !== undefined);
        });

        jQuery(".userDeleting").click(function (e) {
           PartyConnect.deletePerson(e.currentTarget.dataset.id);
        });
     });
  </script>

</div>

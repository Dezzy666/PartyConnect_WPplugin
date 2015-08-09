<?php
/******************************************************************************/
/* Expected variables:                                                        */
/* $dropDownMenu                                                              */
/* $guests                                                                    */
/* PLUGIN_PREFIX                                                              */
/* PLUGIN_SETTINGS_PREFIX                                                     */
/* DROPDOWNMENU_BANNED_VALUE                                                  */
/* OPTION_NAME_GLOBAL                                                         */
/* OPTION_ITEM_ACCEPTED_COLOR                                                 */
/* OPTION_ITEM_DECLINED_COLOR                                                 */
/******************************************************************************/
?>
<div class="wrap">
  <h2><?php echo __('Settings for Party Connect plugin', PLUGIN_PREFIX); ?></h2>
	<h3><?php echo __('Dropdown menu', PLUGIN_PREFIX); ?></h3>

<?php echo __('This dropdown menu provides additional information about guests.<br>e.g.: Each guest can have possibility to take someone with him.<br> Usually you can use "+0" and "+1" for not/bringing partner.', PLUGIN_PREFIX); ?>

  <table>
    <thead>
      <tr><td><?php echo __('Item', PLUGIN_PREFIX); ?></td><td><?php echo __('Delete', PLUGIN_PREFIX); ?></td></tr>
    </thead>
    <tbody>
      <?php
        for ($i = 0; $i < sizeof($dropDownMenu); $i++) {
           if ($dropDownMenu[$i] == DROPDOWNMENU_BANNED_VALUE) {
              continue;
           }
           echo '<tr><td>', $dropDownMenu[$i], '</td><td class="dropdownItemDeleting" data-id="', $i, '">✖</td></tr>';
        }
      ?>
    </tbody>
  </table>

  <table>
     <tr><td><?php echo __('Item for dropdown menu', PLUGIN_PREFIX); ?></td><td><input id="partyConnectDropdownMenuItem"></td></tr>
      <tr><td colspan="2"><div class="button button-primary" id="partyConnectAddItemButton"><?php echo __('Add item', PLUGIN_PREFIX); ?></div></td></tr>
  </table>

  <h3><?php echo __('Guests list', PLUGIN_PREFIX); ?></h3>
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

          switch ($guests[$i]["state"]) {
             case 1:
                echo '<td>',__('Accepted', PLUGIN_PREFIX), '</td>';
                break;
             case 2:
                echo '<td>',__('Declined', PLUGIN_PREFIX), '</td>';
                break;
             case 0:
                echo '<td>',__('Nothing selected', PLUGIN_PREFIX), '</td>';
                break;
             default:
                echo '<td></td>';
                break;
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

  <h3><?php echo __('Row colors', PLUGIN_PREFIX); ?></h3>
  <form method="post" action="options.php">
    <?php
          settings_fields(OPTION_NAME_GLOBAL);
          @do_settings_fields(OPTION_NAME_GLOBAL);

          $acceptedColor = get_option(OPTION_ITEM_ACCEPTED_COLOR);
          $declinedColor = get_option(OPTION_ITEM_DECLINED_COLOR);
    ?>

    <table>
       <tr><td><?php echo __('Accepted row color', PLUGIN_PREFIX); ?></td><td><input type="text" name="<?php echo OPTION_ITEM_ACCEPTED_COLOR; ?>" id="<?php echo OPTION_ITEM_ACCEPTED_COLOR; ?>" type="text" value="<?php echo $acceptedColor; ?>"></td></tr>
       <tr><td><?php echo __('Declined row color', PLUGIN_PREFIX); ?></td><td><input type="text" name="<?php echo OPTION_ITEM_DECLINED_COLOR; ?>" id="<?php echo OPTION_ITEM_DECLINED_COLOR; ?>" type="text" value="<?php echo $declinedColor; ?>"></td></tr>
       <tr><td colspan="2"><?php submit_button(); ?></td></tr>
    </table>
  </form>

  <script>
     jQuery(function () {
        jQuery("#partyConnectAddGuestButton").click(function () {
           PartyConnect.addNewPerson(jQuery("#partyConnectNameInput").val(), jQuery("#partyConnectDropdownInput").attr('checked') !== undefined);
        });

        jQuery(".userDeleting").click(function (e) {
           PartyConnect.deletePerson(e.currentTarget.dataset.id);
        });

        jQuery("#partyConnectAddItemButton").click(function () {
           PartyConnect.addDropdownMenuItem(jQuery("#partyConnectDropdownMenuItem").val());
        });

        jQuery(".dropdownItemDeleting").click(function (e) {
           PartyConnect.deleteDropdownMenuItem(e.currentTarget.dataset.id);
        });
     });
  </script>

</div>

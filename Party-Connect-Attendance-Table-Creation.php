<?php
/******************************************************************************/
/* Expected variables:                                                        */
/* $dropDownMenu                                                              */
/* $guests                                                                    */
/* PLUGIN_PREFIX                                                              */
/******************************************************************************/
?>
<?php
function generateDropDownMenu($selected, $dropDownMenu, $id) {
  echo '<select id="partyConnectSelectFor',$id,'">';
  for ($j = 0; $j < sizeof($dropDownMenu); $j++) {
      if ($selected == $j) {
         $selected = ' selected="selected" ';
      } else {
         $selected = '';
      }
      echo '<option value="', $j, '"', $selected, '>', $dropDownMenu[$j], '</option>';
   }
   echo '</select>';
}

?>

<table>
  <thead>
    <tr><td colspan="2"><?php echo __('Name', PLUGIN_PREFIX); ?></td><td><?php echo __('Presence', PLUGIN_PREFIX); ?></td></tr>
  </thead>
  <tbody>
     <?php
        for ($i = 0; $i < sizeof($guests); $i++) {
           echo '<tr>';
           echo '<td>', $guests[$i]["name"], '</td>';
           echo '<td>';
           if ($guests[$i]["dropdownMenu"] == 1) {
              generateDropDownMenu($guests[$i]["dropdownMenuValue"], $dropDownMenu, $i);
           }
           echo '</td>';
           echo '<td><div class="acceptButton" data-id="',$i,'">', __('Accept', PLUGIN_PREFIX), '</div><div class="declineButton" data-id="',$i,'">', __('Decline', PLUGIN_PREFIX), '</div></td>';
           echo '</tr>';
        }

     ?>
  </tbody>
</table>

<script>
   jQuery(function () {
      jQuery(".acceptButton").click(function (e) {
         var id = e.target.dataset.id,
             callback = function (response) {
                jQuery(e.target).parent().parent().css({"background-color": "green"});
             };

         if(jQuery("#partyConnectSelectFor" + id).get(0) !== undefined) {
            PartyConnect.updateState(id, callback, 1, jQuery("#partyConnectSelectFor" + id).val());
         } else {
            PartyConnect.updateState(id, callback, 1);
         }
      });

      jQuery(".declineButton").click(function (e) {
         var id = e.target.dataset.id,
             callback = function (response) {
                jQuery(e.target).parent().parent().css({"background-color": "red"});
             };

         if(jQuery("#partyConnectSelectFor" + id).get(0) !== undefined) {
            PartyConnect.updateState(id, callback, 2, jQuery("#partyConnectSelectFor" + id).val());
         } else {
            PartyConnect.updateState(id, callback, 2);
         }
      });
   });
</script>

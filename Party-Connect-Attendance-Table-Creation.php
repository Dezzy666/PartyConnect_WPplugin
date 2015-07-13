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
         $selectedString = ' selected="selected" ';
      } else {
         $selectedString = '';
      }
      echo '<option value="', $j, '"', $selectedString, '>', $dropDownMenu[$j], '</option>';
   }
   echo '</select>';
}

?>

<table class="partyConnectMainTable">
  <thead>
    <tr><td colspan="2"><?php echo __('Name', PLUGIN_PREFIX); ?></td><td><?php echo __('Presence', PLUGIN_PREFIX); ?></td></tr>
  </thead>
  <tbody>
     <?php
        for ($i = 0; $i < sizeof($guests); $i++) {
           switch ($guests[$i]["state"]) {
              case 0:
                 echo '<tr>';
                 break;
              case 1:
                 echo '<tr class="accepted">';
                 break;
              case 2:
                 echo '<tr class="declined">';
                 break;
           }
           echo '<td class="guestName">', $guests[$i]["name"], '</td>';
           echo '<td class="dropdownMenu">';
           if ($guests[$i]["dropdownMenu"] == 1) {
              generateDropDownMenu($guests[$i]["dropdownMenuValue"], $dropDownMenu, $i);
           }
           echo '</td>';
           echo '<td class="buttons"><div class="userButton acceptButton" data-id="',$i,'">', __('Accept', PLUGIN_PREFIX), '</div><div class="userButton declineButton" data-id="',$i,'">', __('Decline', PLUGIN_PREFIX), '</div></td>';
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
                jQuery(e.target).parent().parent().removeClass("declined").addClass("accepted");
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
                jQuery(e.target).parent().parent().removeClass("accepted").addClass("declined");
             };

         if(jQuery("#partyConnectSelectFor" + id).get(0) !== undefined) {
            PartyConnect.updateState(id, callback, 2, jQuery("#partyConnectSelectFor" + id).val());
         } else {
            PartyConnect.updateState(id, callback, 2);
         }
      });
   });
</script>

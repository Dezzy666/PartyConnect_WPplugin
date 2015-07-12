<?php
/******************************************************************************/
/* Expected variables:                                                        */
/* $dropDownMenu                                                              */
/* $guests                                                                    */
/* PLUGIN_PREFIX                                                              */
/******************************************************************************/
?>
<?php
function generateDropDownMenu($selected, $dropDownMenu) {
  echo '<select>';
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
              generateDropDownMenu($guests[$i]["dropdownMenuValue"], $dropDownMenu);
           }
           echo '</td>';
           echo '<td><div>', __('Accept', PLUGIN_PREFIX), '</div><div>', __('Decline', PLUGIN_PREFIX), '</div></td>';
           echo '</tr>';
        }

     ?>
  </tbody>
</table>
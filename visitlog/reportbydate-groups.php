<?php

if (isset($_POST['location'])){
$_SESSION['location'] = $_POST['location'];}

$locationId = $_SESSION['location'];

fnOpenDB();
$result = mysql_query("SELECT id, name FROM signinlocations;");

echo '<div id="setLocation"><form name="input" action="?action=groupslog" method="post">
    <input type="hidden" name="set" size="10" value="true">';

echo "<select name='location' id='locations' onchange='this.form.submit()'>";
echo "<option value=''>Please Select a Location...</option>";
while ($row = mysql_fetch_array($result)) {
    if ($row['id'] == $locationId){echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>";}else{echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";}
}
echo "</select>";

if (!empty($locationId)){
echo "<br /><br /><a class='iframe' href=\"addstudent.php?l=$locationId\">Add A Student</a>";
echo " | <a href=\"?action=currently\">Current Log</a>";
}

echo "</div>";


fnCloseDB();


if (!empty($locationId)){
    
                $total = 0;
		$sql = "SELECT * FROM `log` WHERE dateTimeIn >= '$dateRequested1 00:00:00' AND dateTimeIn <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' AND `sid`='99987' ORDER BY dateTimeIn DESC";
            
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		echo '<h1>Sign In/Out Log for Small Groups</h1>';
                
                echo '<form name="input" action="?action=groupslog" method="post">';
                echo '<p>Start Date: <input type="text" id="datepicker" name="datepicker1" value="'.$dateRequested1.'">End Date: <input type="text" id="datepicker2" name="datepicker2" value="'.$dateRequested2.'">';
                echo '<input type="submit" value="Go"></p></form>';
		
        echo "<br /><table class=\"tablesorter\"> ";
		echo "<thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Number in Group</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;

                $groupParts = explode("/",$data->place);
                
                $total += $groupParts['1'];
               
                if (empty($data->dateTimeOut)){
                    echo "<tr><td>".$groupParts['0']."</td><td>".$groupParts['1']."</td><td>$data->dateTimeIn</td><td><a href=\"theygone.php?id=$data->id&l=a\">Sign Out?</a></td></tr>";
                }else{
                    echo "<tr><td>".$groupParts['0']."</td><td>".$groupParts['1']."</td><td>$data->dateTimeIn</td><td>$data->dateTimeOut</td></tr>";
                }
               
			$row_count++;
		}
		echo "<tfoor><tr><td><em><strong>Totals:</strong></em></td><td><em><strong>".$total."</strong></em></td><td></td><td></td></tr></tfoot>";
                echo "</tbody></table>";
		
                echo '<p>&nbsp;</p><p>Page Last Updated: ' . date('r') . '</p>';
                
		fnCloseDB();
                
}else{
    echo '<p>Please select a location to continue. --------------------------></p>';
}                
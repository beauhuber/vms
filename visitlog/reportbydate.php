<?php

if (isset($_POST['location'])){
$_SESSION['location'] = $_POST['location'];}

if (isset($_POST['places'])){
$_SESSION['places'] = $_POST['places'];}

$placeLimit = $_SESSION['places'];
$locationId = $_SESSION['location'];


fnOpenDB();
$result = mysql_query("SELECT id, name FROM signinlocations ORDER BY building ASC");

echo '<div id="setLocation"><form name="input" action="?action=currently" method="post">
    <input type="hidden" name="set" size="10" value="true">';

echo "<select name='location' id='locations' onchange='this.form.submit()'>";
echo "<option value=''>Please Select a Location...</option>";
while ($row = mysql_fetch_array($result)) {
    if ($row['id'] == $locationId){echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>";}else{echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";}
}
echo "</select>";

/***********  For MS *******************/
if ($locationId == '3'){
    echo '<div style="float:right;">';
    echo '<input type="hidden" name="PlacesSet" size="10" value="true">';

    $result = mysql_query("SELECT place FROM places WHERE `building`='2';");

    echo "<select name='places' onchange='this.form.submit()'>";
    echo "<option value=''>Show All</option>";
    while ($row = mysql_fetch_array($result)) {
        if ($placeLimit == $row['place']){
            echo "<option value='" . $row['place'] . "' selected=\"selected\">" . $row['place'] . "</option>";
        }else{
            echo "<option value='" . $row['place'] . "'>" . $row['place'] . "</option>";
        }
    }
    echo "</select>";                    
    echo '</div>';
}
/***********  END MS *******************/

if (!empty($locationId)){
echo "<br /><br /><a class='iframe' href=\"addstudent.php?l=$locationId\">Add A Student</a>";
if ($locationId == '3'){echo " | <a href=\"?action=groupslog\">Small Group Log</a>";}
echo " | <a href=\"epass/\">ePass</a> | <a href=\"../visitlog-public/?firelog=true&location=".$locationId."\">Printable Emergency Log</a>";
}

echo "</div>";

fnCloseDB();


if (!empty($locationId)){
    
                if (!empty($placeLimit) && $locationId == '3'){
                    $sql = "SELECT * FROM `log` WHERE dateTimeIn >= '$dateRequested1 00:00:00' AND dateTimeIn <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' AND `place`='$placeLimit' ORDER BY ePassTime DESC, dateTimeIn DESC";
                }else{
                    $sql = "SELECT * FROM `log` WHERE dateTimeIn >= '$dateRequested1 00:00:00' AND dateTimeIn <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' OR `ePassTime` >= '$dateRequested1 00:00:00' AND ePassTime <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' ORDER BY ePassTime DESC, dateTimeIn DESC";
                    //echo $sql;
                }
            
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		echo '<h1>Sign In/Out Log - '.$num.'</h1>';
               
                echo '<p>Start Date: <input type="text" id="datepicker" name="datepicker1" value="'.$dateRequested1.'">End Date: <input type="text" id="datepicker2" name="datepicker2" value="'.$dateRequested2.'">';
                echo '<input type="submit" value="Go"></p>';
		
        echo "<table class=\"tablesorter\"> ";
		echo "<thead>
                        <tr>
                            <th>Student</th>
                            <th>Search By Student</th>
                            <th>From</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>ePass Time</th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;

               
                if (empty($data->dateTimeOut)){
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td><a href=\"?action=bySid&sid=$data->sid\">Find all log entries</a></td><td>$data->place</td><td>$data->dateTimeIn</td><td><a href=\"theygone.php?id=$data->id&l=a\">Sign Out?</a></td><td>$data->ePassTime</td></tr>";
                }elseif($data->dateTimeOut == 'Did Not Sign Out'){
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td><a href=\"?action=bySid&sid=$data->sid\">Find all log entries</a></td><td>$data->place</td><td>$data->dateTimeIn</td><td><span style=\"color:red\">$data->dateTimeOut</span></td><td>$data->ePassTime</td></tr>";
                }else{
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td><a href=\"?action=bySid&sid=$data->sid\">Find all log entries</a></td><td>$data->place</td><td>$data->dateTimeIn</td><td>$data->dateTimeOut</td><td>$data->ePassTime</td></tr>";
                }
               
			$row_count++;
		}
		echo "</tbody></table>";
		
                echo '<p>&nbsp;</p><p>Page Last Updated: ' . date('r') . '</p>';
                
		fnCloseDB();
                
                
                
}else{
    echo '<p>Please select a location to continue. ------------------------------------------------------------></p>';
}            

echo '</form>';
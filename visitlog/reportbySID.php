<?php

if (isset($_POST['location'])){
$_SESSION['location'] = $_POST['location'];}

if (isset($_POST['places'])){
$_SESSION['places'] = $_POST['places'];}

if (isset($_REQUEST['sid'])){
$_SESSION['sid'] = $_REQUEST['sid'];}

$placeLimit = $_SESSION['places'];
$locationId = $_SESSION['location'];
$studentID = $_SESSION['sid'];


fnOpenDB();
$result = mysql_query("SELECT id, name FROM signinlocations;");

echo '<div id="setLocation"><form name="input" action="?action=bySid" method="post">
    <input type="hidden" name="set" size="10" value="true">';

echo "<select name='location' id='locations' onchange='this.form.submit()'>";
echo "<option value=''>Please Select a Location...</option>";
while ($row = mysql_fetch_array($result)) {
    if ($row['id'] == $locationId){echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>";}else{echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";}
}
echo "</select>";


if (!empty($locationId)){echo "<br /><br /><a class='iframe' href=\"addstudent.php?l=$locationId\">Add A Student</a> | <a href=\"?action=currently\">Current Log</a>";}

echo "</div>";

fnCloseDB();

echo '<p>Student ID: <input type="text" id="sid" name="sid" value="'.$studentID.'">';
                echo '<input type="submit" value="Go"></p>';

if (!empty($studentID)){
    
               $sql = "SELECT * FROM `log` WHERE `sid`='$studentID' ORDER BY dateTimeIn DESC";
            
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		echo '<h1>Sign In/Out Log for '.fnGetNameBySidClean($studentID).' - '.$num.'</h1>';
     
		
        echo "<table class=\"tablesorter\"> ";
		echo "<thead>
                        <tr>
                            <th>From</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Location</th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;

               
                if (empty($data->dateTimeOut)){
                    echo "<tr><td>$data->place</td><td>$data->dateTimeIn</td><td><a href=\"theygone.php?id=$data->id&l=a\">Sign Out?</a></td><td>".fnGetLocatonById($data->signinlocation)."</td></tr>";
                }elseif($data->dateTimeOut == 'Did Not Sign Out'){
                    echo "<tr><td>$data->place</td><td>$data->dateTimeIn</td><td><span style=\"color:red\">$data->dateTimeOut</span></td><td>".fnGetLocatonById($data->signinlocation)."</td></tr>";
                }else{
                    echo "<tr><td>$data->place</td><td>$data->dateTimeIn</td><td>$data->dateTimeOut</td><td>".fnGetLocatonById($data->signinlocation)."</td></tr>";
                }
               
			$row_count++;
		}
		echo "</tbody></table>";
		
                echo '<p>&nbsp;</p><p>Page Last Updated: ' . date('r') . '</p>';
                
		fnCloseDB();
                
                
                
}else{
    echo '<p>Please enter a Student ID to continue.</p>';
}            

echo '</form>';
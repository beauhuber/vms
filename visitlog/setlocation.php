<?php

include_once("../config.php");
include_once("../functions.php");

if ($_POST['set'] == 'true'){
    $locations = explode(",",$_POST['location']);
    setcookie("LocationID",$locations['0'], strtotime( '+365 days' ));
    setcookie("LocationName",$locations['1'], strtotime( '+365 days' ));
    setcookie("LocationBuilding",$locations['2'], strtotime( '+365 days' ));
}

echo '<h1>Set the location of this sign in station</h1>';

fnOpenDB();
$result = mysql_query("SELECT * FROM signinlocations;");

echo '<form name="input" action="setlocation.php" method="post">
    <input type="hidden" name="set" size="10" value="true">';

echo "<select name='location' id='locations' onchange='this.form.submit()'>";
while ($row = mysql_fetch_array($result)) {
    if ($_COOKIE["LocationID"] == $row['id']){
        echo "<option value='" . $row['id'] . ",".$row['name'].",".$row['building']."' selected=\"selected\">" . $row['name'] . "</option>";
    }else{
        echo "<option value='" . $row['id'] . ",".$row['name'].",".$row['building']."'>" . $row['name'] . "</option>";
    }
    
}
echo "</select><br /><br />";

fnCloseDB();

echo '<input type="submit" value="Set Location"></form>';


echo '<h1>Debug Information</h1>';
echo '<p><em>If you just set the location you may need to <a href="setlocation.php">realod</a> the page to view the current setting</em></p>';
echo "<p>Current location ID of this station: " . $_COOKIE["LocationID"] . "<br />";
echo "Current building ID of this station: " . $_COOKIE["LocationBuilding"] . "<br />";
echo "Current location name: " . $_COOKIE["LocationName"] . "</p>";
echo '<p><em><a href="index.php">Once you\'ve set the location, click here to being the sign in or out process</a></em></p>';
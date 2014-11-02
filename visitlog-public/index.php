<?php @session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php echo $siteName; ?> Sign In/Out System</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php 
$fireLog = $_REQUEST['firelog'];
echo '<link rel="stylesheet" type="text/css" href="admin.css">';
echo '<link rel="stylesheet" href="colorbox.css" />';
echo '<link rel="stylesheet" href="themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />';
echo '<script type="text/javascript" src="jquery.tablesorter.min.js"></script>';
echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="jquery.colorbox-min.js"></script>
  <script>
  $(function() {
    $("table").tablesorter();
  });
  </script>';
?>
</head>


<?php
if ($_REQUEST['firelog'] == 'true'){
    echo '<body onload="window.print()">';
}else{
    echo '<body>';
}

include("../config.php");
include("../functions.php");

if (isset($_REQUEST['location'])){
$_SESSION['location'] = $_REQUEST['location'];}

if (isset($_POST['places'])){
$_SESSION['places'] = $_POST['places'];}

$placeLimit = $_SESSION['places'];
$locationId = $_SESSION['location'];

fnOpenDB();
$result = mysql_query("SELECT id, name FROM signinlocations;");

echo '<div id="setLocation"><form name="input" action="index.php" method="post">
    <input type="hidden" name="set" size="10" value="true">';

echo "<select name='location' id='locations' onchange='this.form.submit()'>";
echo "<option value=''>Please Select a Location...</option>";
while ($row = mysql_fetch_array($result)) {
    if ($row['id'] == $locationId){echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>";}else{echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";}
}
echo "</select>";

echo "<br /><br /><a href=\"../visitlog/?action=currently\">Full Version (Requires a District Network Connection)</a>";

echo "</div>";

fnCloseDB();


if (!empty($locationId)){
    
                $dateRequested1 = date("Y-m-d");
                $dateRequested2 = date("Y-m-d");

                if ($_REQUEST['firelog'] == 'true'){
                    $sql = "SELECT * FROM `log` WHERE dateTimeIn >= '$dateRequested1 00:00:00' AND dateTimeIn <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' AND dateTimeOut IS NULL ORDER BY dateTimeIn DESC";
                }else{
                    $sql = "SELECT * FROM `log` WHERE dateTimeIn >= '$dateRequested1 00:00:00' AND dateTimeIn <= '$dateRequested2 23:59:59' AND `signinlocation`='$locationId' ORDER BY dateTimeIn DESC";
                } 
                
                
                
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		echo '<h1>Sign In/Out Log - '.$num.'</h1>';
		
        echo "<table class=\"tablesorter\"> ";
		echo "<thead>
                        <tr>
                            <th>Student</th>
                            <th>From</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;

               
                if (empty($data->dateTimeOut)){
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td>$data->place</td><td>$data->dateTimeIn</td><td></td></tr>";
                }elseif($data->dateTimeOut == 'Did Not Sign Out'){
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td>$data->place</td><td>$data->dateTimeIn</td><td><span style=\"color:red\">$data->dateTimeOut</span></td></tr>";
                }else{
                    echo "<tr><td>".fnGetNameBySid($data->sid)."</td><td>$data->place</td><td>$data->dateTimeIn</td><td>$data->dateTimeOut</td></tr>";
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

?>
</div>
</body>
</html>
<?php
@session_start();

$action = $_REQUEST['action'];

if (empty($_COOKIE["LocationID"]) || empty($_COOKIE["LocationName"])){
    if ($action == 'setlocation' || $action == 'stats' || $action == 'currently' || $action == 'groupslog' || $action == 'bySid'){
        //nothing to see here
    }else{
        echo "<meta http-equiv=\"refresh\" content=\"0; url=setlocation.php\">" ;
        }
} 

$siteName = $_COOKIE["LocationName"];
$locationId = $_COOKIE["LocationID"];
$building = $_COOKIE["LocationBuilding"];

include_once("header.php");

switch ($action){
	
	default:
		
		echo '<h1>Welcome to the '.$siteName.'. Please choose an option below.</h1>';
		
                echo '<a href="?action=signin" class="buttonIn">Sign In</a>';
                		
		echo '<br /><br />';
		
		echo '<a href="?action=checkout" class="buttonOut">Sign Out</a>';
		
                echo '<div id="date">' . date("l, F j, Y") . "</div>";
                echo '<div id="clock"></div>';
		
	break;
	
        case 'setlocation':
            
            include_once ("setlocation.php");
            
        break;
        
        case 'signin':
            
                $placeDecoded = urldecode($_REQUEST['place']);
		
		echo '<h1>Welcome to the '.$siteName.'. <br /><br />Please enter your student ID and select where you coming from.</h1>';
		
		if (isset($_REQUEST['reason']) && $_REQUEST['reason'] == 'nosid'){echo '<p class="error">You must enter a Student ID to continue.</p>';}
                if (isset($_REQUEST['reason']) && $_REQUEST['reason'] == 'noplace'){echo '<p class="error">You must select where you came from to continue.</p>';}
                if (isset($_REQUEST['reason']) && $_REQUEST['reason'] == 'invalidsid'){echo '<p class="error">You must enter a valid Student ID to continue.</p>';}
		
		echo '<form name="input" action="?action=recordcheckin" method="post">
		<p>Enter your Student ID:<input type="text" name="sid" size="60" value="'.$_REQUEST['sid'].'"></p>';
                		
		fnOpenDB();
		$result = mysql_query("SELECT * FROM places WHERE `building`='$building';");
		
		echo "<p>Where are you coming from?</p><select name='places' id='mydropdown'>";
                echo "<option value=''></option>";
		while ($row = mysql_fetch_array($result)) {
                    if ($placeDecoded == $row['place']){
                        echo "<option value='" . $row['place'] . "' selected=\"selected\">" . $row['place'] . "</option>";
                    }else{
                        echo "<option value='" . $row['place'] . "'>" . $row['place'] . "</option>";
                    }
		}
		echo "</select><br /><br />";
		
		fnCloseDB();
		
		echo '<input type="submit" value="Confirm Sign In" class="buttonIn2"></form>';
		
		
		
	break;
        
        case 'groupsignin':
	
                $studentID = $_REQUEST['sid'];
            
		echo '<div id="wrap"><h1>Please enter your group information.</h1></div>';
				
		echo '<form name="input" action="?action=recordgroup" method="post">
		<p>Staff Member\'s Name:<input type="text" name="teacher" size="50"> 
                Number of Students:<input type="text" name="number" size="20"></p></div>';
                
                echo '<div id="virtualKeyboard"></div><p>&nbsp;</p>';
                		
		
		fnCloseDB();
		
		echo '<div id="wrap"><input type="submit" value="Confirm Sign In" class="buttonIn2"></form>';
		
		
		
	break;
	
	case 'recordcheckin':
            
            	$studentID = $_REQUEST['sid'];
		$place = $_REQUEST['places'];
                             
                if(empty($studentID) && $place == 'Small Group'){
                        echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=groupsignin&sid=99987\">" ;
                }elseif(isset($studentID) && $place == 'ePass'){
                        echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=ePassSignIn&sid=$studentID\">" ;
                }elseif (empty($studentID) || empty($place)){
                         
                        if (isset($place) && empty($studentID)){
                            $URLEP = urlencode($place);
                            echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=signin&reason=nosid&place=$URLEP\">" ;
                        }elseif (isset($studentID) && empty ($place)){
                            echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=signin&reason=noplace&sid=$studentID\">" ;
                        }else{
                            echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=signin&reason=nodata\">" ;
                        }
                }else{
                    
                 if (!fnIsValidSid($studentID)){
                     echo "<meta http-equiv=\"refresh\" content=\"0; url={$_SERVER['HTTP_REFERER']}&reason=invalidsid\">" ;
                     exit();
                 }
                    
                $sql = "INSERT INTO `log` (`id`, `sid`, `place`, `dateTimeIn`,`signinlocation`) VALUES ('', '$studentID', '$place', NOW(),'$locationId');";
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		
		fnCloseDB();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=checkedin&sid=$studentID\">" ;
		}
		
		
	break;
        
        case 'ePassSignIn':
		
		$studentID = $_REQUEST['sid'];
		
		if (empty($studentID)){
			echo "<meta http-equiv=\"refresh\" content=\"0; url={$_SERVER['HTTP_REFERER']}&reason=nosid\">" ;
		}else{
	
		$sql = "UPDATE  `log` SET  `dateTimeIn` =  NOW() WHERE  `sid`='$studentID' AND `signinlocation`='$locationId' AND `ePassTime` IS NOT NULL LIMIT 1;";
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		fnCloseDB();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=checkedin&sid=$studentID\">" ;
		}
		
		
	break;
        
        case 'recordgroup':
            
            	$teacher = $_REQUEST['teacher'];
                $number = $_REQUEST['number'];
                             
                if (empty($teacher) || empty($number)){
			echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=home\">" ;
		}else{
                    
                 $place = $teacher . "/" . $number;
                    
                $sql = "INSERT INTO `log` (`id`, `sid`, `place`, `dateTimeIn`,`signinlocation`) VALUES ('', '99987', '$place', NOW(),'$locationId');";
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		
		fnCloseDB();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=checkedin&sid=99987\">" ;
		}
		
		
	break;
        
                
        case 'groupsignout':
            
                echo '<h1>Small Group Sign Out</h1>';
            
		$sql = "SELECT id, place, dateTimeIn  FROM `log` WHERE `dateTimeOut` IS NULL AND `sid`='99987' AND `signinlocation`='$locationId' ORDER BY dateTimeIn DESC";
            
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
                if ($num == 0){
                    echo '<p>No small groups are currently signed in</p>';
                    echo "<meta http-equiv=\"refresh\" content=\"2; url=?action=home\">" ;
                }
		
        echo "<table width=\"100%\"> ";
		echo "<thead>
                        <tr>
                            <th><h1>Group</h1></th>
                            <th><h1>Time In</h1></th>
                            <th><h1>Sign Out</h1></th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;


                    echo "<tr><td>$data->place</td><td>$data->dateTimeIn</td><td><a href=\"theygone.php?id=$data->id&l=s\" class=\"groupOut\">Sign Out?</a></td></tr>";
               
			$row_count++;
		}
		echo "</tbody></table>";
		
                
		fnCloseDB();
		
		
	break;
        
	
	case 'checkedin':
	
                $studentID = $_REQUEST['sid'];
            
		echo '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p class="note">'.fnGetNameBySidClean($studentID).' you\'ve been successfully signed into the '.$siteName.'.  Please remeber to sign out.  Thank You!</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';
		
		echo "<meta http-equiv=\"refresh\" content=\"2; url=?action=home\">" ;
		
	break;
	
	
	case 'checkedout':
            
                $studentID = $_REQUEST['sid'];
		
		echo '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p class="note">'.fnGetNameBySidClean($studentID).' you\'ve been successfully signed out of the '.$siteName.'.  Thank You!</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';
		
		echo "<meta http-equiv=\"refresh\" content=\"2; url=?action=home\">" ;
		
	break;
	
	case 'checkout':
		
		echo '<h1>Thank you for using the '.$siteName.'<br /><br />Please enter your student ID.</h1>';
		
		if (isset($_REQUEST['reason'])){echo '<p class="error">You must enter a Student ID to continue.</p>';}
		
		echo '<form name="input" action="?action=recordcheckout" method="post">
		<br /><br /><input type="text" name="sid" size="60"><br /><br />
		<input type="submit" value="Sign Out" class="buttonOut">
		</form>';
                
                if ($locationId == '3'){
                    echo '<br /><a href="?action=groupsignout" class="startOver">Small Group Sign Out</a>';
                }
		
	break;
	
	case 'recordcheckout':
		
		$studentID = $_REQUEST['sid'];
		
		if (empty($studentID)){
			echo "<meta http-equiv=\"refresh\" content=\"0; url={$_SERVER['HTTP_REFERER']}&reason=nosid\">" ;
		}else{
	
		$sql = "UPDATE  `log` SET  `dateTimeOut` =  NOW() WHERE  `sid`='$studentID' AND `signinlocation`='$locationId' AND `dateTimeOut` IS NULL LIMIT 1;";
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		fnCloseDB();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=checkedout&sid=$studentID\">" ;
		}
		
		
	break;
	
	case 'currently':
		
        include_once("reportbydate.php");	
		
	break;
    
	case 'groupslog':
		
        include_once("reportbydate-groups.php");	
		
	break;
    
	case 'bySid':
		
        include_once("reportbySID.php");	
		
	break;
   
}

include_once("footer.php");
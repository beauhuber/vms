<?php include("header.php"); 

$action = $_REQUEST['action'];

switch ($action){
    
    
    default:
    case 'start':

    echo '<div style="float:right;">';
    echo '<p><a href="../index.php?action=currently">Current Sign In/Out Log</a>';
    echo '</div>'; 
        
    echo '<form name="input" action="?action=search" method="post">';
    echo '<p>First, Last, or Student ID: <input type="text" id="term" name="term">';
    echo '<input type="submit" value="Find Students"></p>';
    echo '</form>';

   
    break;


    case 'search':
        
        $searchTerm = $_REQUEST['term'];
        
        if (!empty($searchTerm)){
            
                echo '<div style="float:right;">';
                echo '<p><a href="../index.php?action=currently">Current Sign In/Out Log</a>';
                echo '</div>';
    
               $sql = "SELECT * FROM `students` WHERE `sid` LIKE '%$searchTerm%' OR first LIKE '%$searchTerm%' OR last LIKE '%$searchTerm%' ORDER BY last;";
            
                $color1 = "trmain"; 
		$color2 = "trmain2"; 
                $row_count = 0;
                
		fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		echo '<h1>Search Results - '.$num.'</h1>';
                
                echo '<form name="input" action="?action=search" method="post">';
                echo '<p>First, Last, or Student ID: <input type="text" id="term" name="term" value="'.$searchTerm.'">';
                echo '<input type="submit" value="Find Students"></p>';
                echo '</form>';
                
     
		
        echo "<table class=\"tablesorter\"> ";
		echo "<thead>
                        <tr>
                            <th>First</th>
                            <th>Last</th>
                            <th>Grade</th>
                            <th>Student ID</th>
                            <th>Fill Out an ePass</th>
                         </tr>
                       </thead>
                       <tbody>";

		while ($data = mysql_fetch_object($res)) {

		$row_color = ($row_count % 2) ? $color1 : $color2;

                echo "<tr><td>$data->first</td><td>$data->last</td><td>$data->grade</td><td>$data->sid</td><td><a href=\"?action=fillout&sid=$data->sid\" class='iframe'>ePass</a></td></tr>";
                
                $row_count++;
		
                
                }
		echo "</tbody></table>";
	
                
		fnCloseDB();
                
                
                
        }else{
            
            echo '<form name="input" action="?action=search" method="post">';
            echo '<p>First, Last, or Student ID: <input type="text" id="term" name="term">';
            echo '<input type="submit" value="Find Students"></p>';
            echo '</form>';
            
        } 

    break;
    
    case 'fillout':
        $studentID = $_REQUEST['sid'];
        fnOpenDB();
        
        $result = mysql_query("SELECT sid, first, last, grade FROM `students` WHERE `sid`='$studentID' LIMIT 1;");
        while ($row = mysql_fetch_array($result)) {
        ?>
                <h1>Fill out an ePass for <?php echo $row['first'] . ' ' .$row['last']; ?></h1>
		<form method="post" action="?action=ePassDone">
                <input type="hidden" name="sid" size="10" value="<?php echo $studentID; ?>">
                
                <p>Grade: <?php echo $row['grade']; ?> <br /> Student ID: <?php echo $studentID; ?></p>
								
		<label class="description" for="building"><strong>Where are they going?</strong></label>
		<div>               
                <?php
                }
                
                $result = mysql_query("SELECT * FROM `signinlocations`;");
                                
                echo "<select name='location' id='location'>";
                echo "<option value=''></option>";
                while ($row = mysql_fetch_array($result)) {
                    if ($_COOKIE['lastlocation'] == $row['id']){
                        echo "<option value='" . $row['id'] . "' selected=\"selected\">" . $row['name'] . "</option>";
                    }else{
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                }
                
                echo "</select>";
                ?>
		</div>                       
		<label class="description" for="reason"><strong>Reason for Visit (Limited to 200 Characters)</strong></label>
		<div>
			<input id="element_5" name="reason" type="text" maxlength="200" size="100" size value=""/> 
		</div> 
                
                
                <label class="description" for="staffname"><strong>Your Name</strong></label>
		<div>
			<input id="element_6" name="staffname" type="text" maxlength="50" value="<?php echo @$_COOKIE['staffname']; ?>"/> 
		</div> 
                
                <label class="description" for="dateexpected"><strong>Date Expected</strong></label>
		<div>
			<input id="element_7" name="dateexpected" type="text" value="<?php echo date("Y-m-d"); ?>"/> 
		</div>
                
                
                <label class="description" for="timeexpected"><strong>Time Expected</strong></label>
		<div>
			<input id="element_7" name="timeexpected" type="text" value="<?php echo date("h:i"); ?>"/> 
		</div>
                
                
                
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</form>	
        <?php
        fnCloseDB();
    break;
    
    case 'ePassDone':
        
                $studentID = $_REQUEST['sid'];
                $location = $_REQUEST['location'];
                $reason = $_REQUEST['reason'];
                $staffname = $_REQUEST['staffname'];
                $dateexpected = $_REQUEST['dateexpected'];
                $timeexpected = $_REQUEST['timeexpected'];
                
                setcookie("staffname",$staffname, strtotime( '+365 days' ));
                setcookie("lastlocation",$location, strtotime( '+365 days' ));
                             
                if (empty($staffname) || empty($studentID)){
			echo "no data recieved" ;
		}else{
                    
                 $from = "[EP] " . $staffname . "/" . $reason;
                 
                 $dateTime = $dateexpected .' '. $timeexpected . ':00';
                    
                $sql = "INSERT INTO `log` (`id`, `sid`, `place`, `ePassTime`,`signinlocation`) VALUES ('', '$studentID', '$from', '$dateTime','$location');";
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		
		fnCloseDB();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=?action=thankyou\">" ;
		}
        
    break;
    
    case 'thankyou';
        
       echo '<p>The ePass has been submited.  When the students goes to sign have them choose enter their student id and choose the ePass option.</p>';
       
    break;
}

include("footer.php");
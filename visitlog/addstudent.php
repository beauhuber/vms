<?php

include_once("../config.php");
include_once("../functions.php");

$action = $_REQUEST['action'];

switch ($action){
    
    default:
        $studentID = $_REQUEST['sid'];
        $locationID = $_REQUEST['l'];
        
        if (!empty($locationID)){
            fnOpenDB();
            $result = mysql_query("SELECT building FROM `signinlocations` WHERE `id`='$locationID' LIMIT 1;");
            while ($row = mysql_fetch_array($result)) {
                $building = $row['building'];
            }
            fnCloseDB();
            
        }
        
        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add a student</title>
</head>
<body>
		<h1><a>Add A Student</a></h1>
		<form method="post" action="addstudent.php?action=add">
		</div>						
		<label class="description" for="sid">Student ID </label>
		<div>
                    <input id="element_3" name="sid" type="text" maxlength="254" value="<?php echo $studentID; ?>"/> 
		</div> 
		<label class="description" for="fname">First Name </label>
		<div>
			<input id="element_1" name="fname" type="text" maxlength="254" value=""/> 
		</div> 
		<label class="description" for="lname">Last Name </label>
		<div>
			<input id="element_2" name="lname" type="text" maxlength="245" value=""/> 
		</div> 
		<label class="description" for="grade">Grade </label>
		<div>
			<input id="element_4" name="grade" type="text" maxlength="2" value=""/> 
		</div> 
		<label class="description" for="building">Building </label>
		<div>               
                <?php
                fnOpenDB();
                $result = mysql_query("SELECT * FROM buildings;");
                                
                echo "<select name='building' id='building'>";
                echo "<option value=''></option>";
                while ($row = mysql_fetch_array($result)) {
                    if ($building == $row['id']){
                    echo "<option value='" . $row['id'] . "' selected=\"selected\">" . $row['name'] . "</option>";    
                    }else{
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                }
                
                echo "</select>";
                fnCloseDB();
                ?>
		</div> 
		<label class="description" for="campusID">Campus Person ID </label>
		<div>
			<input id="element_5" name="campusID" type="text" maxlength="25" value=""/> 
		</div> 
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</form>	
</body>
</html>
<?php   
        
        
        
     break;
    
        
     case 'add':
         
         $studentID = $_REQUEST['sid'];
         $firstName = $_REQUEST['fname'];
         $lastName = $_REQUEST['lname'];
         $grade = $_REQUEST['grade'];
         $building = $_REQUEST['building'];
         $campusID = $_REQUEST['campusID'];
         
         if (empty($studentID) || empty($firstName) || empty($lastName) || empty($grade) || empty($building) || empty($campusID)){
             echo '<p>All fields are required; please try again.</p>';
         }else{
             
          fnOpenDB();
             
             $query = sprintf("INSERT INTO `students`(`sid`, `first`, `last`, `grade`, `building`, `campusID`) VALUES ('%s','%s','%s','%s','%s','%s');",
            mysql_real_escape_string($studentID),
            mysql_real_escape_string($firstName),
            mysql_real_escape_string($lastName),
            mysql_real_escape_string($grade),
            mysql_real_escape_string($building),
            mysql_real_escape_string($campusID));
             
             
             
             // Perform Query
            $result = mysql_query($query);

            // Check result
            // This shows the actual query sent to MySQL, and the error. Useful for debugging.
            if (!$result) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }else{
                header("Location: addstudent.php?action=added");
                exit();
            }
             
             
             fnCloseDB();
         }
         
         
         
     break;
 
     case 'added':
         
         echo '<p>Student Added.</p>';
         
     break;
    
}
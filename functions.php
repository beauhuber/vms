<?php

/**
 * Opens a MySQL Database connection 
 *
 * @author       Beau Huber
 * @version      1.1
 */

if ( !function_exists('fnOpenDB') ) {
	function fnOpenDB(){
	 global $link;
	 include ("config.php");
	  $link = mysql_connect($databaseserver,$datausername,$datapassword) or die
	("[Error]: Couldn't connect to the database server.  Please contact your administrator.");
	  if (! mysql_select_db($databasename,$link)){
	   echo ("<br /><strong>[Error]: Unable to select the requested database.  Please contact your administrator.");
	  }
	}
}


/**
 * Closes a MySQL Database connection
 *
 * @author       Beau Huber
 * @version      1.0
 */
if ( !function_exists('fnCloseDB') ) {
	function fnCloseDB(){
	 global $link;
	include ("config.php");
	   mysql_close($link);
	}
}



/**
 * Gets student info by student id
 *
 * @author       Beau Huber
 * @version      1.1
 */
if ( !function_exists('fnGetNameBySid') ) {
	function fnGetNameBySid($sid){

                include ("config.php");
                $sql = "SELECT first, last, grade, campusID FROM students WHERE `sid`='$sid' LIMIT 1";
            
            	fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		if ($num == 0){return $sid . ' (<a class=\'iframe\' href="addstudent.php?sid='.$sid.'">Student ID not in database</a>)';}else{
		
		while ($data = mysql_fetch_object($res)) {
                    
                        if ($data->campusID == 'XXXX'){
                            
                            return $data->last ." ". $data->first;
                            
                        }else{

                            return "<a class='iframe' href=\"campusIframe.php?campusID=".$data->campusID."\" target=\"_blank\">".$data->last .", ". $data->first ." (". $data->grade .")</a>";
                            
                        }   
		}}
		
		fnCloseDB();
            
	}
}



/**
 * Gets student info by student id
 *
 * @author       Beau Huber
 * @version      1.0
 */
if ( !function_exists('fnGetNameBySidClean') ) {
	function fnGetNameBySidClean($sid){

                include ("config.php");
                $sql = "SELECT first, last FROM students WHERE `sid`='$sid' LIMIT 1";
            
            	fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		if ($num == 0){return $sid . ' (Your student ID wasn\'t found.  Did you enter it correctly?)';}else{
		
		while ($data = mysql_fetch_object($res)) {

			return  $data->first . " " . $data->last;
		}}
		
		fnCloseDB();
            
	}
}


/**
 * Gets student info by student id
 *
 * @author       Beau Huber
 * @version      1.0
 */
if ( !function_exists('fnIsValidSid') ) {
	function fnIsValidSid($sid){

                include ("config.php");
                $sql = "SELECT campusID FROM students WHERE `sid`='$sid' LIMIT 1";
            
            	fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		if ($num == 0){return false;}else{return true;}
		
		fnCloseDB();
            
	}
}


/**
 * Gets student info by student id
 *
 * @author       Beau Huber
 * @version      1.0
 */
if ( !function_exists('fnGetLocatonById') ) {
	function fnGetLocatonById($id){

                include ("config.php");
                $sql = "SELECT name FROM `signinlocations` WHERE `id`='$id' LIMIT 1";
            
            	fnOpenDB();
		$res = mysql_query($sql);
		$num = mysql_num_rows($res);
		
		if ($num == 0){return $id . ' (Location Not Found)';}else{
		
		while ($data = mysql_fetch_object($res)) {

			return  $data->name;
		}}
		
		fnCloseDB();
            
	}
}
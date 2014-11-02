<?php

include_once("../config.php");
include_once("../functions.php");

$id = $_REQUEST['id'];
$lastPage = $_REQUEST['l'];


if (!is_numeric($id)){
    header("Location: index.php?action=currently");
    exit();
}

                $sql = "UPDATE  `log` SET  `dateTimeOut` =  NOW() WHERE  `id`='$id' LIMIT 1;";
                
		fnOpenDB();
		
		$result = mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}

		
		fnCloseDB();
		
                if ($lastPage == 'a'){
                    header("Location: index.php?action=currently");
                    exit();
                }elseif($lastPage == 's'){
                    header("Location: index.php");
                    exit();
                }
                
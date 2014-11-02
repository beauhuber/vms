<?php

include_once("../config.php");
include_once("../functions.php");

if (date('G') >= '19' && date('G') <= '21'){
    
    fnOpenDB();
    
    $query = "UPDATE `log` SET `dateTimeOut`='Did Not Sign Out' WHERE `dateTimeOut` IS NULL;";

    $result = mysql_query($query);
    

    if (!$result) {
        $runStatus = '[FAIL] ['. mysql_error() . '] ';
        exit();
    }
    
    mysql_free_result($result);
    
    
    $query = "UPDATE `log` SET dateTimeIn=NOW(), dateTimeOut='Did Not Sign Out' WHERE `dateTimeIn` IS NULL AND `ePassTime` IS NOT NULL;";

    $result = mysql_query($query);
    

    if (!$result) {
        $runStatus = '[FAIL] ['. mysql_error() . '] ';
        exit();
    }
    
    mysql_free_result($result);
    
    $runStatus = '[Success] ';
    
    fnCloseDB();
    
}else{
    
    $runStatus = '[FAIL] ';
    
}


$file = 'lastrun.txt';
$lastRun = $runStatus . date('r') . "\n";
file_put_contents($file, $lastRun, FILE_APPEND | LOCK_EX);
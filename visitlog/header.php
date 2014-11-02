<?php 

include_once("../config.php");
include_once("../functions.php");

if (empty($siteName)){
    $siteName = "";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php echo $siteName; ?> Sign In/Out System</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="clock.js"></script>
<?php if ($action == 'currently' || $action == 'stats' || $action == 'setlocation' || $action == 'groupslog' || $action == 'bySid'){

echo '<link rel="stylesheet" type="text/css" href="admin.css">';
echo '<link rel="stylesheet" href="colorbox.css" />';
echo '<link rel="stylesheet" href="themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />';
if ($action == 'currently' || $action == 'groupslog'){
    
    $dateRequested1 = $_POST['datepicker1'];
    $dateRequested2 = $_POST['datepicker2'];

    if (empty($dateRequested1)){$dateRequested1 = date("Y-m-d");}
    if (empty($dateRequested2)){$dateRequested2 = date("Y-m-d");}
    
    if ($dateRequested1 == date("Y-m-d") && $dateRequested2 == date("Y-m-d")){
    
        if (isset($_SESSION['location']) && $action == 'currently'){
            echo '<meta http-equiv="refresh" content="'.rand(45,120).'">';
        }
    
    }
    }
echo '<script type="text/javascript" src="jquery.tablesorter.min.js"></script>';
echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="jquery.colorbox-min.js"></script>
  <script>
  $(function() {
    $("table").tablesorter();
    $(".iframe").colorbox({iframe:true, width:"50%", height:"80%"});
    $("#datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
    $("#datepicker2").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
  });
  </script>';

    
}else{
if ($action == 'groupsignin'){
echo '  <meta charset="utf-8">
        <link rel="stylesheet" href="onscreenkeyboard/css/jsKeyboard.css" type="text/css" media="screen"/>
        <script src="onscreenkeyboard/js/vendor/bootstrap.min.js"></script>
        <script type="text/javascript" src="onscreenkeyboard/js/jsKeyboard.js"></script>
        <script src="onscreenkeyboard/js/main.js"></script>';
}?>
<link rel="stylesheet" type="text/css" href="style.css">
<?php } ?>

</head>

<body>
<?php if ($action == 'groupsignin'){echo '<div id="wrap2">';}else{echo '<div id="wrap">';}


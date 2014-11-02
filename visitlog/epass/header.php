<?php 

include_once("../../config.php");
include_once("../../functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>ePass Sign In/Out System</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php
echo '<link rel="stylesheet" type="text/css" href="../admin.css">';
echo '<link rel="stylesheet" href="../colorbox.css" />';
echo '<link rel="stylesheet" href="../themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />';
echo '<script type="text/javascript" src="../jquery.tablesorter.min.js"></script>';
echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="../jquery.colorbox-min.js"></script>
  <script>
  $(function() {
    $("table").tablesorter();
    $(".iframe").colorbox({iframe:true, width:"50%", height:"80%"});
    $("#datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
  });
  </script>';
?>
</head>

<body>
<div id="wrap2">


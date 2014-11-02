<style type="text/css">
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	-webkit-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9dce2c), color-stop(1, #8cb82b) );
	background:-moz-linear-gradient( center top, #9dce2c 5%, #8cb82b 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#9dce2c', endColorstr='#8cb82b');
	background-color:#9dce2c;
	-webkit-border-top-left-radius:15px;
	-moz-border-radius-topleft:15px;
	border-top-left-radius:15px;
	-webkit-border-top-right-radius:15px;
	-moz-border-radius-topright:15px;
	border-top-right-radius:15px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0;
	border:1px solid #83c41a;
	display:inline-block;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:50px;
	line-height:50px;
	width:86px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #689324;
}
.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8cb82b), color-stop(1, #9dce2c) );
	background:-moz-linear-gradient( center top, #8cb82b 5%, #9dce2c 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8cb82b', endColorstr='#9dce2c');
	background-color:#8cb82b;
}.classname:active {
	position:relative;
	top:1px;
}</style>
<?php

$viewWhat = $_REQUEST['what'];
$campusID = $_REQUEST['campusID'];

if (empty($campusID)){
    die("CID Missing");
}

echo   '<a href="?what=summary&campusID='.$campusID.'" class="classname">Summary</a>
        <a href="?what=schedule&campusID='.$campusID.'" class="classname">Schedule</a>
        <a href="?what=attendance&campusID='.$campusID.'" class="classname">Attendance</a><br /><br />';

switch ($viewWhat){
    
    default:
    case 'summary':
        
        echo '<iframe src="'.$campusSummaryUrl.'" width="100%" height="600px" frameborder="0"></iframe>';
        
    break;

    case 'schedule':
        
        echo '<iframe src="'.$campusScheduleUrl.'" width="100%" height="600px" frameborder="0"></iframe>';
        
    break;

    case 'attendance':
        
        echo '<iframe src="'.$campusAttendanceUrl.'" width="100%" height="600px" frameborder="0"></iframe>';
        
    break;

}
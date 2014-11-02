

<?php

if ($action == 'checkin' || $action == 'checkout' || $action == 'signin'){

			echo '<script type="text/javascript" language="JavaScript">
					document.forms[\'input\'].elements[\'sid\'].focus();
				 </script>';
			
} 

if ($action == 'currently' || $action == 'stats' || $action == 'groupslog' || $action == 'bySid'){}else{

?>

<p><a href="?action=home" class="startOver">Start Over</a></p>

    
 <?php } ?>
    
</div>
</body>
</html>

<?php
session_start();

	$destination = $_POST['destinationTB'];

	//append destination to URL
	header("Location:../view/index.php?destination=".$destination);

?>



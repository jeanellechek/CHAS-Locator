<?php
include ("DAO.php"); 
include ("controller.php"); 

//connect to DB
$sqldao = DAO_Factory::getSQLDAO();
$conn = $sqldao->connect();

$source = $_POST['sourceTB'];
$id = $_POST['id'];

//retrieve the marker's lat and lng
 $sql = $conn->prepare("SELECT lat,lng from chas where id=?");
		  $sql->bind_param("i",$id);
		  $sql->execute();
		  $result = $sql->get_result();
		  $num_of_rows = $result->num_rows;

		  while ($row = $result->fetch_assoc()) {
			  //save each record into row for adding markers
		  $dLat = $row['lat'];
		  $dLng=$row['lng'];
		  }
		  //append destination lat,lng and source name
header("Location:../view/index.php?destLat=".$dLat."&destLng=".$dLng."&source=".$source);

?>
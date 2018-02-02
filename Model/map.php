<script src="../assets/js/map.js"></script>

<?php
class MapCHAS
{
    public static function nearestClinics($vLat,$vLng,$vRange)
    {
		$sqldao = DAO_Factory::getSQLDAO();
		$conn = $sqldao->connect();
        //Get nearest CHAS clinics using haversine formula
        $sql = $conn->prepare("SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( lat) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?)) * sin ( radians( lat ) ) ) ) AS distance FROM chas having distance <= ? order by distance");
        $sql->bind_param("dddi", $vLat, $vLng, $vLat, $vRange);
        $sql->execute();
        $result = $sql->get_result();
		return $result;
    }
	public static function getDirections($destLat,$destLng,$srcLat,$srcLng,$mode){
		//get directions for various modes
		  echo "initMap($destLat,$destLng,$srcLat,$srcLng,'$mode');";
             
             
         } 
		 
		 public static function nearestClinicMarkers($vLat,$vLng,$vRange){
			 //add nearest markers to the map
			 $result = MapCHAS::nearestClinics($vLat,$vLng,$vRange);
			 while ($row = $result->fetch_assoc()) {
                 //save each record into row for adding markers
                 $Slat      = $row['lat'];
                 $Slng      = $row['lng'];
                 $name      = $row['name'];
                 $telephone = $row['Telephone'];
                 $type      = $row['Dental'];
                 $id        = $row['id'];
                 $address   = "Blk " . $row['ADDRESSBLOCKHOUSENUMBER'] . " " . $row['ADDRESSSTREETNAME'] . " #" . $row['ADDRESSFLOORNUMBER'] . "-" . $row['ADDRESSUNITNUMBER'];
                 if ($type == 0)
                     $type = "Medical";
                 else
                     $type = "Dental";
                 echo "addMarker($Slat,$Slng,'$name',$telephone,'$type','$address',$id);";
             }
             echo "addMarkerDestination($vLat,$vLng);";
		 }
		 
		 
	}
?>
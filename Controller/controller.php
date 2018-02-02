<script src="../assets/js/map.js"></script>
<?php
include("../model/DAO.php");
class Controller
{
    public static function main($srcLat, $srcLng, $destLat, $destLng, $source,$mode)
    { 
	//With destination name
        if (($destLat == "") && ($destLng == "") && ($srcLat == "") && ($srcLng =="") && ($source =="")&&($mode=="")) {
            echo "searchAddressDestination();";
        }
		
		//With destination and source x,y
         else if (($srcLat != "") && ($srcLng != "") && ($destLat != "") && ($destLng != "") && ($source =="") && ($mode !="")) {
            MapCHAS::getDirections($destLat,$destLng,$srcLat,$srcLng,$mode);
        }
		//With source name
         else if ($source != "") {
            echo "searchAddressSource($destLng,$destLat,'$source');";
        }
		else
			 MapCHAS::nearestClinicMarkers($destLat, $destLng, $_SESSION['Range']);
        
    }
    
    
}
?>

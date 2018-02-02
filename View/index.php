<!doctype html>
<html lang="en">
   <?php
	  include("../controller/controller.php");
	  include("../model/map.php");
	  //start session
      session_start();
	  unset($_SESSION['keyword']);
	  unset($_SESSION['filterType']);
      
      //First time visit, set range
      if (!isset($_SESSION['Range'])) {
          $_SESSION['Range']    = "2";
      }
      ?>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>CHAS Locator</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <meta name="viewport" content="width=device-width" />
      <!-- Bootstrap core CSS     -->
      <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
      <!-- CHAS CSS     -->
      <link href="../assets/css/chas.css" rel="stylesheet" />
      <!-- Animation library for notifications   -->
      <link href="../assets/css/animate.min.css" rel="stylesheet" />
      <!--  Paper Dashboard core CSS    -->
      <link href="../assets/css/paper-dashboard.css" rel="stylesheet" />
      <!--  FooterCollapsible core CSS    -->
      <link href="../assets/css/footerStyle.css" rel="stylesheet" />
      <!--  Fonts and icons     -->
      <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
      <link href="../assets/css/themify-icons.css" rel="stylesheet">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- CSS for transport tab-->
      <style>
      </style>
   </head>
   <body>
      <div class="wrapper">
         <div class="sidebar" data-background-color="white" data-active-color="danger">
            <!-- side bar menu -->
            <div class="sidebar-wrapper">
               <div class="logo">
                  <a href="index.php" class="simple-text">
                  <img src="../assets/img/CHASLOGO.png" width="40%">
                  </a>
               </div>
               <ul class="nav">
                  <li class="active">
                     <a href="index.php">
                        <i class="ti-panel"></i>
                        <p>Home Page</p>
                     </a>
                  </li>
                  <li>
                     <a href="https://www.chas.sg/content.aspx?id=303">
                        <i class="ti-user"></i>
                        <p>About CHAS</p>
                     </a>
                  </li>
                  <li>
                     <a href="searchCHAS.php?page=1">
                        <i class="ti-view-list-alt"></i>
                        <p>Search CHAS</p>
                     </a>
                  </li>
                  <li>
                     <a href="feedback.php">
                        <i class="ti-bell"></i>
                        <p>Feedback</p>
                     </a>
                  </li>
                  <li>
                     <a href="settings.php">
                        <i class="ti-settings"></i>
                        <p>Settings</p>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="main-panel">
            <nav class="navbar navbar-default">
               <div class="container-fluid">
                  <div class="navbar-header">
                     <a class="navbar-brand" href="#">Home</a>
                  </div>
               </div>
            </nav>
            <!-- Index Menu -->
            <div class="content" style="padding-bottom:0px;">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card" style="z-index: 0;">
                           <div class="header">
                              <h4 class="title">CHAS Locator</h4>
                              <p class="category">Locate A CHAS Clinic</p>
                           </div>
                           <div class="content">
                              <!-- search nearby clinics -->
                              <form method="POST" action="../model/searchSQL.php">
                                 <input type="text" class="form-control" placeholder="Enter destination" name="destinationTB" id="destinationTB" style="width:90%;" <?php if (!empty($_GET[ 'destination'])) echo "value='" . $_GET[ 'destination'] . "'"; ?> required>
                                 </input>
                                 <input type="hidden" name="destinationLat" id="destinationLat" />
                                 <input type="hidden" name="destinationLng" id="destinationLng" />
                                 <input type="hidden" id="radius" value="<?php
                                    echo $_SESSION['Range'];
                                    ?>" />
                                 <input type="submit" value="Search" class="form-button" />
                                 <!-- google translate -->
                                 <div id="google_translate_element" style="display:none"></div>
                              </form>
                              <hr/>
                              <!-- MAP -->
                              <div id="map-canvas"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- getting there & nearest clinic tab -->
               <div class="panel-group" id="accordion">
                  <div class="panel panel-default" id="gettingThereTAB">
                     <div class="panel-heading">
                        <div class="panel-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                              <?php
                                 if (!isset($_GET['srcLat']) && !isset($_GET['srcLng']) && !isset($_GET['destLng']) && !isset($_GET['destLat'])) {
                                 ?>
                              <script>
                                 document.getElementById("gettingThereTAB").style.display = "none";
                              </script>
                              <?php
                                 } else if (isset($_GET['srcLat']) && isset($_GET['srcLng']) && isset($_GET['destLng']) && isset($_GET['destLat'])) {
                                 ?>
                              Getting There
                              <?php
                                 } else if (isset($_GET['destLng']) && isset($_GET['destLat']) && !isset($_GET['srcLat']) && !isset($_GET['srcLng'])) {
                                 ?>
                              Nearest Clinics
                              <?php
                                 }
                                 ?>
                           </a>
                        </div>
                     </div>
                     <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                           <?php
                              if (isset($_GET['srcLat']) && isset($_GET['srcLng']) && isset($_GET['destLng']) && isset($_GET['destLat'])) {
                              ?>
                           <!-- display routes -->
                           <div class="container1">
                              <div class="tab">
                                 <button class="tablinks" onclick="openDirection(<?php echo $_GET['destLat']?>,<?php echo $_GET['destLng']?>,<?php echo $_GET['srcLat']?>,<?php echo $_GET['srcLng']?>,event, 'WALKING')" id="walkingTAB" <?php if(isset($_GET['mode']) && $_GET['mode'] =="WALKING") {?>style="background-color:#ddd;"<?php }?>>Walking</button>
                                 <button class="tablinks" onclick="openDirection(<?php echo $_GET['destLat']?>,<?php echo $_GET['destLng']?>,<?php echo $_GET['srcLat']?>,<?php echo $_GET['srcLng']?>,event, 'DRIVING')" id="drivingTAB" <?php if(isset($_GET['mode']) && $_GET['mode'] =="DRIVING") {?>style="background-color:#ddd;"<?php }?>>Driving</button>
                                 <button class="tablinks" onclick="openDirection(<?php echo $_GET['destLat']?>,<?php echo $_GET['destLng']?>,<?php echo $_GET['srcLat']?>,<?php echo $_GET['srcLng']?>,event, 'TRANSIT')" id="transitTAB" <?php if(isset($_GET['mode']) && $_GET['mode'] =="TRANSIT") {?>style="background-color:#ddd;"<?php }?>>Public Transport</button>
                              </div>
                              <div id="WALKING" class="tabcontent" style="<?php if($_GET['mode'] != "WALKING") {?>display:none;<?php }?>">
                              </div>
                              <div id="DRIVING" class="tabcontent" style="<?php if($_GET['mode'] != "DRIVING") {?>display:none;<?php }?>">
                              </div>
                              <div id="TRANSIT" class="tabcontent" style="<?php if($_GET['mode'] != "TRANSIT") {?>display:none;<?php }?>">
                              </div>
							<script>  <?php if(!isset($_GET['click'])){?>
							  document.getElementById("walkingTAB").click();<?php } ?></script>
                           </div>
                           <?php
                              } else if (isset($_GET['destLng']) && isset($_GET['destLat']) && !isset($_GET['srcLat']) && !isset($_GET['srcLng'])) {
                              ?>
                           <!-- List of nearby clinics -->
                           <div class="container1" style="background-color:#fff; color:#000; overflow: scroll;height:200px;">
                              <table border="0" class="table table-striped">
                                 <thead>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Telephone</th>
                                    <th>Distance</th>
                                 </thead>
                                 <?php
                                   $result = MapCHAS::nearestClinics($_GET['destLat'], $_GET['destLng'],$_SESSION['Range']);
                                    $recordNo    = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $roundedDistance = round($row['distance'], 2, PHP_ROUND_HALF_UP);
                                    ?>
                                 <tr>
                                    <td>
                                       <?php echo $recordNo; ?>
                                    </td>
                                    <td>
                                       <?php echo $name = $row['name']; ?>
                                    </td>
                                    <td>
                                       <?php
                                          if ($row['Dental'] == 0)
                                              echo "MEDICAL";
                                          else
                                              echo "DENTAL";
                                          ?>
                                    </td>
                                    <td>BLOCK <?php echo $row['ADDRESSBLOCKHOUSENUMBER']; ?>
                                       <?php echo $row['ADDRESSSTREETNAME']; ?> ,
                                       <?php if ($row['ADDRESSFLOORNUMBER'] != "" && $row['ADDRESSUNITNUMBER'] != "") { ?>#
                                       <?php echo $row['ADDRESSFLOORNUMBER']; ?> -
                                       <?php echo $row['ADDRESSUNITNUMBER']; ?>,
                                       <?php } ?> SINGAPORE
                                       <?php echo $row['ADDRESSPOSTALCODE'].","; ?>
                                       <?php if ($row['ADDRESSBUILDINGNAME'] != "-") echo $row['ADDRESSBUILDINGNAME']; ?>
                                    </td>
                                    <td>
                                       <?php echo $row['Telephone']; ?>
                                    </td>
                                    <td>
                                       <?php echo $roundedDistance; ?> KM
                                    </td>
                                    <td>
									<input type='button' href='#myModal' value='Route' data-toggle='modal' id='<?php
                                       echo $row["id"];?>' data-target='#route-modal' class='btn btn-info btn-fill' /></td>
                                 </tr>
                                 <?php $recordNo++;
                                    } ?>
                              </table>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
   <!--   Core JS Files   -->
   <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
   <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
   <!--  Checkbox, Radio & Switch Plugins -->
   <script src="../assets/js/bootstrap-checkbox-radio.js"></script>
   <!--  Charts Plugin -->
   <script src="../assets/js/chartist.min.js"></script>
   <!--  Notifications Plugin    -->
   <script src="../assets/js/bootstrap-notify.js"></script>
   <!-- Google translate -->
   <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   <script src="../assets/js/googleTranslate.js"></script>
   <script src="../assets/js/prompt.js"></script>
   <!-- Google map -->
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOuTQTlE0WANfIqv5-RzsEDfIIV6wdA-k&libraries=geometry&libraries=places&callback=initialize" async defer></script>
   <script src="../assets/js/map.js"></script>
   <!-- initialize map -->
   <script type="text/javascript">
      var map = null;
      var marker = null;
      var activeWindow = null;
      
      
      var destinationAdd = document.getElementById("destinationTB").value;
      
      //initialize map
      function initialize() {
      
          var mapOptions = {
              center: {
                  lat: 1.3521,
                  lng: 103.8198,
      
              },
              zoom: 12,
              zoomControl: true,
			  streetViewControl: false,
      
          };
          //autocomplete 
          autocomplete = new google.maps.places.Autocomplete(
              (document.getElementById('destinationTB')),
              //restrict to singapore
              {
                  componentRestrictions: {
                      country: 'SG'
                  }
              });
      
          google.maps.event.addListener(autocomplete, 'place_changed', function() {
              var place = autocomplete.getPlace();
      
              for (var i = 0; i < place.address_components.length; i++) {
                  if (place.address_components[i].types[0] == "locality") {
                      console.log(place['address_components'][i]['long_name']);
                      break;
                  }
              }
      
          });
      
      
          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
          <?php
		  if (isset($_GET['srcLat']) && isset($_GET['srcLng']) && isset($_GET['mode']))
			  Controller :: main($_GET['srcLat'],$_GET['srcLng'],$_GET['destLat'],$_GET['destLng'],"",$_GET['mode']);
		  
		  else if ((!isset($_GET['destLat']) && !isset($_GET['destLng']))) 
			  Controller :: main("","","","","","");
		  
		  else if(isset($_GET['source']))
			  Controller :: main("","",$_GET['destLat'],$_GET['destLng'],$_GET['source'],"");
		  
		  else
			  Controller :: main("","",$_GET['destLat'],$_GET['destLng'],"","");
?>
	  }
      
   </script>
   <!-- modal to enter source -->
   <div id="route-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Route</h4>
            <form id="completeForm" action="../model/routeSQL.php" method="POST">
         </div>
         <!-- Modal Body -->
         <div class="modal-body">
         <div class="form-group">
         Enter Source Address:
         <input type="text" class="form-control" id="sourceTB" name="sourceTB" style="width:250px;" id="sourceTB" placeholder="Enter Source" required/>
         </div>
         <div class="form-group">
         <input type="hidden" id="id" name="id" />
         </div>
         <!-- Modal Footer -->
         <div class="modal-footer">
         <input class="btn btn-default" type="submit" title="Route me there now!" name="routeBTN" id="routeBTN" />
         </form>
         </div>
         </div>
      </div>
   </div>
   <!-- pass values into modal -->
   <script>
      $('#route-modal').on('show.bs.modal', function(e) {
          var modal = $(this),
              esseyId = e.relatedTarget.id;
          $(".modal-body #id").val(esseyId);
      
      })
  
   
   <?php if(isset($_GET['invalidDest']))
	   echo "invalidDest();";
   else if(isset($_GET['invalidSrc']))
	   echo "invalidSrc();";
   else if(isset($_GET['notInSG']))
   {
	   $field = $_GET['notInSG'];
	   echo "notInSG('$field');";
   }
   ?>
    </script>
</html>


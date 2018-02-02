<!doctype html>
<html lang="en">
   <?php 
	  include ("../model/DAO.php");
      
      //start session
      session_start();
      if($_GET['page'] =="")
		   header("Location:../view/searchCHAS.php?page=1");
      ?>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>CHAS Locator</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <meta name="viewport" content="width=device-width" />
      <!-- Jquery -->
      <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
      <!-- Bootstrap core CSS     -->
      <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
      <!-- Animation library for notifications   -->
      <link href="../assets/css/animate.min.css" rel="stylesheet"/>
      <!--  Paper Dashboard core CSS    -->
      <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>
      <!--  Fonts and icons     -->
      <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
      <link href="../assets/css/themify-icons.css" rel="stylesheet">
   </head>
   <body>
      <div class="wrapper">
         <div class="sidebar" data-background-color="white" data-active-color="danger">
            <!-- Side bar menu -->
            <div class="sidebar-wrapper">
               <div class="logo">
                  <a href="index.php" class="simple-text">
                  <img src="../assets/img/CHASLOGO.png" width="40%">
                  </a>
               </div>
               <ul class="nav">
                  <li>
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
                  <li class="active">
                     <a href="searchchas.php?page=1">
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
         <!-- Search CHAS Menu -->
         <div class="main-panel">
            <nav class="navbar navbar-default">
               <div class="container-fluid">
                  <div class="navbar-header">
                     <a class="navbar-brand" href="#">Search CHAS</a>
                  </div>
               </div>
            </nav>
            <div class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="header">
                              <h4 class="title">Search CHAS</h4>
                              <p class="category">View The List Of All CHAS Clinics & Dental</p>
                           </div>
                           <div class="content">
                              <!-- Input for search bar -->
                              <form method="POST" action="../model/searchCHASRedirect.php">
                                 <input type="text" class="form-control" placeholder="Enter Name/Address/Telephone" name="keywordTB" style="width:90%;" <?php if(!empty($_SESSION['keyword'])) echo "value='".$_SESSION['keyword']."'";?>>
                                 </input>
                                 <!-- Filter button -->
                                 <input type="submit" value="Filter" class="form-button"/><br/><br/>
                                 <!-- Filter CHAS by type -->
                                 Filter By Clinic Type:
                                 <select name="filterDL" class="form-control" style="width:20%;">
                                    <option value="ALL" <?php 
                                       if((!empty($_SESSION['filterType']) && ($_SESSION['filterType'] == "ALL"))) echo "Selected"?>>ALL</option>
                                    <option value="MEDICAL" 
                                       <?php 
                                          if((!empty($_SESSION['filterType']) && ($_SESSION['filterType'] == "MEDICAL"))) echo "Selected"?>>MEDICAL</option>
                                    <option value="DENTAL" <?php 
                                       if((!empty($_SESSION['filterType']) && ($_SESSION['filterType'] == "DENTAL"))) echo "Selected"?>>DENTAL</option>
                                 </select>
                              </form>
                              <!-- Database queries for filtered CHAS clinics -->
                              <div class="content table-responsive table-full-width">
                                 <?php 
								 $sqldao = DAO_Factory::getSQLDAO();
								 $conn = $sqldao->connect();
								 $result = $sqldao->filter($_GET['page']);
								 $totalRecord= $sqldao->numberRecords();?>
                                 <table width="92%">
                                    <tr>
									<td>
									<b><?php echo $totalRecord; ?> CHAS CLINIC RECORDS</b>
									</td>
                                       <td>
                                          <h6 style="text-align:right;">
                                             Page <?php echo $_GET['page']?> 
                                          </h6>
                                       </td>
                                    </tr>
                                 </table>
                                 <hr/>
                                 <!-- google translate -->
                                 <div id="google_translate_element" style="display:none;"></div>
								 <?php echo "<script>googleTranslateElementInit();</script>" ;?>
                                 <table class="table table-striped">
                                    <thead>
									<th>S/N</th>
                                       <th>Name</th>
                                       <th>Type</th>
                                       <th>Address</th>
                                       <th>Telephone</th>
                                       <th></th>
                                    </thead>
                                    <tbody>
                                       <!-- display 20 records per page -->
                                       <?php
                                          $index=1;
										  
										 
										  if ($totalRecord % 20 == 0)
											  $totalPage = $totalRecord / 20; //whole number pages
										  else if($totalRecord <20)
											  $totalPage = 1;
										  else
											  $totalPage = round(($totalRecord / 20) + 1); //decimal page numbers, ceiling
										  $count=0;
										  
										  while ($row = $result->fetch_assoc()) { ?>
                                       <tr>
									   <td><?php echo $count=($_GET['page']-1)*20+$index;?></td>
                                          <td width="25%"><?php echo $row['name']?></td>
                                          <td><?php echo $row['Dental'];?></td>
                                          <td width="40%">BLOCK <?php echo $row['ADDRESSBLOCKHOUSENUMBER']?> <?php echo $row['ADDRESSSTREETNAME']?> , <?php if($row['ADDRESSFLOORNUMBER'] != "" && $row['ADDRESSUNITNUMBER'] !=""){?>#<?php echo $row['ADDRESSFLOORNUMBER']?> - <?php echo $row['ADDRESSUNITNUMBER'];?>,<?php }?> SINGAPORE <?php echo $row['ADDRESSPOSTALCODE']."<br/>"?>	<?php if($row['ADDRESSBUILDINGNAME'] != "-")echo $row['ADDRESSBUILDINGNAME']?> </td>
                                          <td width="15%"><?php echo $row['Telephone']?></td>
                                          <td>
                                             <input type="button" href="#myModal" value ="Route" data-toggle="modal" id="<?php echo $row['id']?>" data-target="#edit-modal" class="btn btn-info btn-fill"/>
                                          </td>
                                       </tr>
                                       <?php $index++; }?>
                                    </tbody>
                                 </table>
                                 <div id="pageNumber" style="margin-left:30%; margin-right:auto; text-align:center;">
                                    <table width="40%" border="0">
                                       <tr>
                                          <td width="5%">
                                             <!-- previous button -->
                                             <?php if($_GET['page'] != 1){?>
                                             <form action="../model/searchCHASRedirect.php" method="POST">
                                                <input type="hidden" value="<?php echo $_GET['page']?>" name="previousTB"/>
                                                <input type="submit" value="<< Previous" class="btn btn-info btn-fill"/>
                                             </form>
                                             <?php }?>
                                          </td>
                                          <!-- page number -->
                                          <td width="20%">
                                             <form action="../model/searchCHASRedirect.php" method="POST">
                                                Page<br/><input type="number" name="pageNoTB" value="<?php echo $_GET['page']?>" min="1" max="<?php echo $totalPage;?>" style="width:50px; text-align:center;" required/> 
                                             </form>
                                          </td>
                                          <!-- next button -->
                                          <td width="5%">
                                             <?php if($_GET['page'] != $totalPage){?>
                                             <form action="../model/searchCHASRedirect.php" method="POST">
                                                <input type="hidden" value="<?php echo $_GET['page']?>" name="nextTB"/>
                                                <?php if($_GET['page'] < $totalPage){?>
                                                <input type="submit" value="Next >>" class="btn btn-info btn-fill"/>
                                             </form>
                                             <?php }}?>
                                          </td>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Route</h4>
               </div>
               <form method="POST" action="../model/routeSQL.php">
                  <div class="modal-body">
                     <!-- input source address -->
                     <div class="form-group">
                        Enter Source Address:
                        <input type="text" class="form-control" id = "sourceTB" style="width:250px;" name="sourceTB" placeholder="Enter Source" required/>	
                     </div>
                     <div class="form-group">
                        <input type="hidden" id = "id" name="id"/>	
                     </div>
                  </div>
                  <div class="modal-footer">
                     <!-- route button -->
                     <button type="submit" class="btn btn-primary">Route</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
   <!-- pass page values into modal -->
   <script>
      $('#edit-modal').on('show.bs.modal', function(e) {
          
          var modal = $(this),
              esseyId = e.relatedTarget.id;
      $(".modal-body #id").val( esseyId );
          
      })
   </script>
   <!--   Core JS Files   -->
   <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
   <!--  Checkbox, Radio & Switch Plugins -->
   <script src="../assets/js/bootstrap-checkbox-radio.js"></script>
   <!--  Charts Plugin -->
   <script src="../assets/js/chartist.min.js"></script>
   <!--  Notifications Plugin    -->
   <script src="../assets/js/bootstrap-notify.js"></script>
   <!-- Paper Dashboard Core javascript and methods -->
   <script src="../assets/js/paper-dashboard.js"></script>
   <!-- Google translate -->
   <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   <script src="../assets/js/googleTranslate.js"></script>
</html>
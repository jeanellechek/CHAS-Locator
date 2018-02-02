<!doctype html>
<html lang="en">
   <?php 
      //start session
      session_start();
	  unset($_SESSION['keyword']);
	  unset($_SESSION['filterType']);
      ?>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>CHAS Locator</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <meta name="viewport" content="width=device-width" />
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
            <!-- side menu bar -->
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
                  <li>
                     <a href="searchCHAS.php?page=1">
                        <i class="ti-view-list-alt"></i>
                        <p>Search CHAS</p>
                     </a>
                  </li>
                  <li class="active">
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
         <!-- Feedback CHAS menu -->
         <div class="main-panel">
            <nav class="navbar navbar-default">
               <div class="container-fluid">
                  <div class="navbar-header">
                     <a class="navbar-brand" href="#">Feedback</a>
                  </div>
               </div>
            </nav>
            <div class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="header">
                              <h4 class="title">Feedback</h4>
                              <p class="category">We value your feedback</p>
                           </div>
                           <div class="content">
                              <div class="content table-responsive table-half-width">
                                 <!-- Feedback form -->
                                 <form method="POST" action="../Model/sendEmailSQL.php">
                                    <table class="table" border="0" >
                                       <tr>
                                          <td width="20%">Subject</td>
                                          <td>
                                             <select name="subjectDL" class="form-control" style="width:40%; background-color:#FFFCF5;">
                                                <option value="enquries">Enquiries</option>
                                                <option value="bugReporting">Application/Bug Reporting</option>
                                                <option value="others">Others</option>
                                             </select>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Email</td>
                                          <td><input type="email" name="emailTB" class="form-control border-input" style="width:40%;" required/></td>
                                       </tr>
                                       <tr>
                                          <td>Comments</td>
                                          <td><textarea rows="4" cols="50" name="comment" class="form-control border-input" required></textarea></td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <center><input type="submit" value="Send" class="form-button"></center>
                                          </td>
                                       </tr>
                                    </table>
                                    <!-- google translate -->
                                    <div id="google_translate_element" style="display:none;"></div>
                                    <?php echo "<script>googleTranslateElementInit();</script>" ;?>
                                 </form>
                              </div>
                           </div>
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
   <!-- Prompt Plugin -->
   <script src="../assets/js/prompt.js"></script>
   <!-- Google translate -->
   <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   <script src="../assets/js/googleTranslate.js"></script>
</html>
<!-- Feedback prompt -->
<?php 
   if(isset($_GET['success']))
   echo "<script>success();</script>";
   else if(isset($_GET['failure']))
   echo "<script>failure();</script>";
   ?>
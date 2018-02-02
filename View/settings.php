<!doctype html>
<html lang="en">
   <?php 
      session_start();
	  unset($_SESSION['keyword']);
	  unset($_SESSION['filterType']);?>
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
                  <li>
                     <a href="feedback.php">
                        <i class="ti-bell"></i>
                        <p>Feedback</p>
                     </a>
                  </li>
                  <li class="active">
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
                     <a class="navbar-brand" href="#">Settings</a>
                  </div>
               </div>
            </nav>
            <div class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="header">
                              <h4 class="title">Settings</h4>
                              <p class="category">Personalise Your CHAS Locator</p>
                           </div>
                           <div class="content">
                              <div class="content table-responsive table-half-width">
                                 <form method="POST" action="../model/settingsSQL.php">
                                    <table class="table" border="0" >
                                       <tr>
                                          <td width="20%">Language</td>
                                          <td>
                                            <div id="google_translate_element"></div>
                                             <?php echo "<script>googleTranslateElementInit();</script>" ;?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Search Range</td>
                                          <td>
                                             <input type="range" min="1" max="5" value="<?php echo $_SESSION['Range'];?>" class="slider" name="rangeSlider" id="myRange" style="width:40%">
                                             <p>Value: <span id="demo"></span>KM</p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <center><input type="submit" value="Save" class="form-button"></center>
                                          </td>
                                       </tr>
                                    </table>
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
   <!-- Slider -->
   <script src="../assets/js/slider.js"></script>
</html>
<!-- Feedback prompt -->
<?php 
   if(isset($_GET['success']))
   echo "<script>success();</script>";
   else if(isset($_GET['failure']))
   echo "<script>failure();</script>";
   ?>
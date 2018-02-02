<?php
   //start session
   session_start();
   
   //import files
   require ('PHPMailerAutoload.php');
   require('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
   require('PHPMailer-master/PHPMailer-master/class.smtp.php');
   
   
   //retrieve parameter from session
   $subject = $_POST['subjectDL'];
   $email = $_POST['emailTB'];
   $comments = $_POST['comment'];
   
   date_default_timezone_set('Asia/Singapore');
   $date = date('Y-m-d H:i:s');
   
   //mail configurations
   $myMail = new PHPMailer;
   $myMail->Mailer = "smtp";
   $myMail->isSMTP();
   $myMail->SMTPAuth = true; 
   $myMail->SMTPSecure = 'tls'; 
   $myMail->From = "chasLocator666@gmail.com";
   $myMail->FromName = "Chas Feedback System";
    $myMail->isHTML(true);
   
   $myMail->addAddress($email, "Client");
   $myMail->Host = "smtp.gmail.com";
   $myMail->Username = 'chasLocator666@gmail.com';
   $myMail->Password = 'group666';
   $myMail->Encoding = "base64"; 
   $myMail->Port = 587;   
   $myMail->Subject = "Feedback on CHAS Locator";
   
   $myMail->Body= "Feedback received on ".$date."<br/><br/> Subject: ".$subject."<br/>".
   "Email: ".$email."<br/><br/>"."Comments:<br/>".$comments."<br/><br/><br/><i>CHAS Locator Admin</i>";
   $result = $myMail->send();
   
   if(!$result)
   {
	   //fail to send email
   	header("Location:../view/feedback.php?failure=1");
   }
   else 
	   //Sent email
   	header("Location:../view/feedback.php?success=1");
   ?>
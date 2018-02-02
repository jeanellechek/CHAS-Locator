<?php
session_start();

//for page navigation
if (isset($_POST['nextTB'])) {
    
    $next = $_POST['nextTB'] + 1;
    header("Location:../view/searchCHAS.php?page=" . $next);
} else if (isset($_POST['previousTB'])) {
    
    $previous = $_POST['previousTB'] - 1;
    header("Location:../view/searchCHAS.php?page=" . $previous);
}


//for moving between pages
if (isset($_POST['nextTB'])) {
		//next button
        $next = $_POST['nextTB'] + 1;
        header("Location:../view/searchCHAS.php?page=" . $next);
    } else if (isset($_POST['previousTB'])) {
        //previous button
        $previous = $_POST['previousTB'] - 1;
        header("Location:../view/searchCHAS.php?page=" . $previous);
    } else if (isset($_POST['pageNoTB'])) {
        header("Location:../view/searchCHAS.php?page=" . $_POST['pageNoTB']);
    } else {
        $_SESSION['keyword']    = $_POST['keywordTB'];
        $_SESSION['filterType'] = $_POST['filterDL'];
        if (isset($_POST['nextBTN']))
            $_POST['nextBTN'] = $_POST['nextBTN'];
        
        if (isset($_POST['pageBTNValue']))
            $_POST['page'] = $_POST['pageBTNValue'];
        //append page number to URL
        header("Location:../view/searchCHAS.php?page=" . $_POST['page']);
    }




?>
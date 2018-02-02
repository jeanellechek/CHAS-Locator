<script src="../assets/js/googleTranslate.js"></script>
<script>
<?php
session_start();
$_SESSION['Range'] = $_POST['rangeSlider'];
$language = $_POST['langDropdown'];
$_SESSION['language'] = $language;

echo "googleTranslateElementInit('$language');";

$message="Settings Saved";
header("Location:../view/settings.php?success=1");
?>
</script>
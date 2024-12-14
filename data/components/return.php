<?php
ob_start();

// Redirect back to the referring page
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
header("Location: $referer");
exit();

ob_end_flush();
?>

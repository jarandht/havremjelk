<?php
$servername = "db";
$username = "php";
$password = "php";
$database = "php";

$conn = new mysqli($servername, $username, $password, $database);

$sqlexpensecategory = "SELECT id, expensecategory_name FROM expensecategory";
$expensecategory = $conn->query($sqlexpensecategory);

$sqlexpensesource = "SELECT id, expensesource_name FROM expensesource";
$expensesource = $conn->query($sqlexpensesource);

$sqlexpensevolumeTypes = "SELECT id, volumeType_name FROM volumeTypes";
$expensevolumeTypes = $conn->query($sqlexpensevolumeTypes);

$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);

$sqldate = "SELECT id FROM dates";
$date = $conn->query($sqldate);

$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);

$sqlstore = "SELECT id, store_name FROM store";
$store = $conn->query($sqlstore);

$sqlyear = "SELECT id, id FROM years ORDER BY id DESC";
$year = $conn->query($sqlyear);

$conn->close();
?>
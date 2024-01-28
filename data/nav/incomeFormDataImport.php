<?php

$conn = new mysqli($servername, $username, $password, $database);

$sqlincomecategory = "SELECT id, incomecategory_name FROM incomecategory";
$incomecategory = $conn->query($sqlincomecategory);
$sqlincomesource = "SELECT id, incomesource_name FROM incomesource";
$incomesource = $conn->query($sqlincomesource);
$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);
$sqldate = "SELECT id, id FROM dates";
$date = $conn->query($sqldate);
$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);
$sqlyear = "SELECT id, id FROM years";
$year = $conn->query($sqlyear);


$conn->close();

?>
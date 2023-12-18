<?php
require 'creds.php';
require 'conponents/head.php';

$conn = new mysqli($servername, $username, $password, $database);

$sqlincomecategory = "SELECT id, incomecategory_name FROM incomecategory";
$incomecategory = $conn->query($sqlincomecategory);
$sqlsource = "SELECT id, source_name FROM source";
$source = $conn->query($sqlsource);
$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);
$sqldate = "SELECT id, id FROM dates";
$date = $conn->query($sqldate);
$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);
$sqlyear = "SELECT id, id FROM years";
$year = $conn->query($sqlyear);

if (isset($_POST["submit"])) {
    $sql = sprintf("INSERT INTO income(chost, year_id, month_id, date_id, day_id, incomecategory_id, source_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $conn->real_escape_string($_POST["txtChost"]),
        $conn->real_escape_string($_POST["txtYear_id"]),
        $conn->real_escape_string($_POST["txtMonth_id"]),
        $conn->real_escape_string($_POST["txtDate_id"]),
        $conn->real_escape_string($_POST["txtDay_id"]),
        $conn->real_escape_string($_POST["txtIncomecategory_id"]),
        $conn->real_escape_string($_POST["txtSource_id"])
    );
    $conn->query($sql);
}

header("Location: /");

$conn->close();
?>

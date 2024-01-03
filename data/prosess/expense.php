<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_POST["submit"])) {
    $expensesource_id = !empty($_POST["txtExpensesource_id"]) ? $conn->real_escape_string($_POST["txtExpensesource_id"]) : "NULL";
    $date_id = !empty($_POST["txtDate_id"]) ? $conn->real_escape_string($_POST["txtDate_id"]) : "NULL";
    $day_id = !empty($_POST["txtDay_id"]) ? $conn->real_escape_string($_POST["txtDay_id"]) : "NULL";
    $store_id = !empty($_POST["txtStore_id"]) ? $conn->real_escape_string($_POST["txtStore_id"]) : "NULL";
    $volumeTypes_id = !empty($_POST["txtExpensevolumeTypes_id"]) ? $conn->real_escape_string($_POST["txtExpensevolumeTypes_id"]) : "NULL";

    $sql = sprintf("INSERT INTO expense (chost, volume, year_id, month_id, expensecategory_id, day_id, date_id, expensesource_id, store_id, volumeTypes_id) VALUES('%s', %s, '%s', %s, %s, %s, %s, %s, %s, %s)",
        $conn->real_escape_string($_POST["txtChost"]),
        $conn->real_escape_string($_POST["txtVolume"]),
        $conn->real_escape_string($_POST["txtYear_id"]),
        $conn->real_escape_string($_POST["txtMonth_id"]),
        $conn->real_escape_string($_POST["txtExpensecategory_id"]),
        $day_id,
        $date_id,
        $expensesource_id,
        $store_id,
        $volumeTypes_id
    );

    $conn->query($sql);

    // Redirect back to the referring page
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    header("Location: $referer");
    exit();
}

$conn->close();
?>
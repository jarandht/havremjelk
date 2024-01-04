<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_POST["submit"])) {
// Get the repeat count
$repeatCount = isset($_POST["repeatCount"]) ? (int)$_POST["repeatCount"] : 1;

// Get selected months as an array
$selectedMonths = isset($_POST["txtMonth_id"]) ? $_POST["txtMonth_id"] : array();

// Get selected years as an array
$selectedYears = isset($_POST["txtYear_id"]) ? $_POST["txtYear_id"] : array();

for ($i = 0; $i < $repeatCount; $i++) {
    foreach ($selectedMonths as $selectedMonth) {
        foreach ($selectedYears as $selectedYear) {
            // Your existing code for processing a single entry
            $expensesource_id = !empty($_POST["txtExpensesource_id"]) ? $conn->real_escape_string($_POST["txtExpensesource_id"]) : "NULL";
            $date_id = !empty($_POST["txtDate_id"]) ? $conn->real_escape_string($_POST["txtDate_id"]) : "NULL";
            $day_id = !empty($_POST["txtDay_id"]) ? $conn->real_escape_string($_POST["txtDay_id"]) : "NULL";
            $store_id = !empty($_POST["txtStore_id"]) ? $conn->real_escape_string($_POST["txtStore_id"]) : "NULL";
            $volumeTypes_id = !empty($_POST["txtExpensevolumeTypes_id"]) ? $conn->real_escape_string($_POST["txtExpensevolumeTypes_id"]) : "NULL";
            $volume = isset($_POST["txtVolume"]) ? $conn->real_escape_string($_POST["txtVolume"]) : "NULL";
            $discount = isset($_POST["txtDiscount"]) ? $conn->real_escape_string($_POST["txtDiscount"]) : "NULL";

            // If volume is not set or is an empty string, set it to NULL
            if ($volume === "NULL" || $volume === "") {
                $volume = "NULL";
            }

            $sql = sprintf("INSERT INTO expense (chost, volume, discount, year_id, month_id, expensecategory_id, day_id, date_id, expensesource_id, store_id, volumeTypes_id) VALUES('%s', %s, '%s', %s, %s, %s, %s, %s, %s, %s, %s)",
                $conn->real_escape_string($_POST["txtChost"]),
                $volume,
                $discount,
                $selectedYear,
                $selectedMonth,
                $conn->real_escape_string($_POST["txtExpensecategory_id"]),
                $day_id,
                $date_id,
                $expensesource_id,
                $store_id,
                $volumeTypes_id
            );

            $conn->query($sql);
        }
    }
}

// Redirect back to the referring page
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
header("Location: $referer");
exit();

}

$conn->close();
?>

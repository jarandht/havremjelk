<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_POST["submit"])) {
    // Get an array of selected months
    $selectedMonths = $_POST["txtMonth_id"];

    foreach ($selectedMonths as $monthId) {
        $incomesource_id = !empty($_POST["txtIncomesource_id"]) ? $conn->real_escape_string($_POST["txtIncomesource_id"]) : "NULL";
        $date_id = !empty($_POST["txtDate_id"]) ? $conn->real_escape_string($_POST["txtDate_id"]) : "NULL";
        $day_id = !empty($_POST["txtDay_id"]) ? $conn->real_escape_string($_POST["txtDay_id"]) : "NULL";

        $sql = sprintf("INSERT INTO income(amount, year_id, month_id, incomecategory_id, day_id, date_id, incomesource_id) VALUES('%s', %s, '%s', %s, %s, %s, %s)",
            $conn->real_escape_string($_POST["txtAmount"]),
            $conn->real_escape_string($_POST["txtYear_id"]),
            $monthId, // Use the current selected month
            $conn->real_escape_string($_POST["txtIncomecategory_id"]),
            $day_id,
            $date_id,
            $incomesource_id
        );

        $conn->query($sql);
    }

    // Redirect back to the referring page
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    header("Location: $referer");
    exit();
}

$conn->close();
?>

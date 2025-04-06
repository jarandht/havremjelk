<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';

// Default repeat count to 1 if not set or empty
$repeatCount = isset($_POST["repeatCount"]) && $_POST["repeatCount"] !== '' ? (int)$_POST["repeatCount"] : 1;

// Handle adding new stores, sources, and categories only once
$expensecategory_id = addExpenseCategory($conn);
$store_id = addStore($conn);
$expensesource_id = addExpenseSource($conn);

// Retrieve values from POST (using index [0] to replicate same data if not an array)
$chost = isset($_POST["txtChost"]) && !is_array($_POST["txtChost"]) ? $conn->real_escape_string($_POST["txtChost"]) : (isset($_POST["txtChost"][0]) ? $conn->real_escape_string($_POST["txtChost"][0]) : "");
$volume = isset($_POST["txtVolume"]) && !is_array($_POST["txtVolume"]) ? $conn->real_escape_string($_POST["txtVolume"]) : (isset($_POST["txtVolume"][0]) ? $conn->real_escape_string($_POST["txtVolume"][0]) : "");
$discount = isset($_POST["txtDiscount"]) && !is_array($_POST["txtDiscount"]) ? $conn->real_escape_string($_POST["txtDiscount"]) : (isset($_POST["txtDiscount"][0]) ? $conn->real_escape_string($_POST["txtDiscount"][0]) : "");
$comment = isset($_POST["txtComment"]) && !is_array($_POST["txtComment"]) ? $conn->real_escape_string($_POST["txtComment"]) : (isset($_POST["txtComment"][0]) ? $conn->real_escape_string($_POST["txtComment"][0]) : "");
$date = isset($_POST["txtDate"]) && !is_array($_POST["txtDate"]) ? $conn->real_escape_string($_POST["txtDate"]) : (isset($_POST["txtDate"][0]) ? $conn->real_escape_string($_POST["txtDate"][0]) : "");

// Loop to insert the same data repeatCount times
for ($i = 0; $i < $repeatCount; $i++) {
    // Skip if the date is empty
    if (empty($date)) {
        continue;
    }

    // Build and execute the SQL query
    $sql = "INSERT INTO expense (chost, volume, discount, comment, expensecategory_id, date, expensesource_id, store_id) VALUES ";
    $sql .= "('$chost', '$volume', '$discount', '$comment', $expensecategory_id, '$date', $expensesource_id, $store_id)";

    // Execute the query and check for errors
    if ($conn->query($sql) === TRUE) {
        // Debug: Uncomment to see successful insertions
        // echo "Inserted entry $i successfully.<br>";
    } else {
        echo "Error on entry $i: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();

// Functions for handling categories, sources, and stores
function addExpenseCategory($conn) {
    if ($_POST["txtExpensecategory_id"] === '__new__') {
        $expensecategory_name = $conn->real_escape_string($_POST["txtExpensecategoryName"]);
        return insertNewRecord($conn, 'expensecategory', 'expensecategory_name', $expensecategory_name);
    } elseif (!empty($_POST["txtExpensecategory_id"])) {
        return $conn->real_escape_string($_POST["txtExpensecategory_id"]);
    } else {
        return "NULL";
    }
}

function addExpenseSource($conn) {
    if ($_POST["txtExpensesource_id"] === '__new__') {
        $expensesource_name = $conn->real_escape_string($_POST["txtExpensesourceName"]);
        return insertNewRecord($conn, 'expensesource', 'expensesource_name', $expensesource_name);
    } elseif (!empty($_POST["txtExpensesource_id"])) {
        return $conn->real_escape_string($_POST["txtExpensesource_id"]);
    } else {
        return "NULL";
    }
}

function addStore($conn) {
    if ($_POST["txtStore_id"] === '__new__') {
        $store_name = $conn->real_escape_string($_POST["txtStoreName"]);
        return insertNewRecord($conn, 'store', 'store_name', $store_name);
    } elseif (!empty($_POST["txtStore_id"])) {
        return $conn->real_escape_string($_POST["txtStore_id"]);
    } else {
        return "NULL";
    }
}

function insertNewRecord($conn, $table, $column, $value) {
    $value = $conn->real_escape_string($value);
    $insertSql = "INSERT INTO $table ($column) VALUES ('$value')";
    if ($conn->query($insertSql) === TRUE) {
        return $conn->insert_id;
    } else {
        echo "Error inserting new record: " . $insertSql . "<br>" . $conn->error;
        return null;
    }
}
?>

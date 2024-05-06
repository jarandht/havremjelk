<?php
require '../../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Default repeat count to 1 if not set or empty
$repeatCount = isset($_POST["repeatCount"]) && $_POST["repeatCount"] !== '' ? (int)$_POST["repeatCount"] : 1;

// Handle adding new stores, sources, and categories only once
$expensecategory_id = addExpenseCategory($conn);
$store_id = addStore($conn);
$expensesource_id = addExpenseSource($conn);

// Loop through each item
for ($i = 0; $i < $repeatCount; $i++) {
    // Retrieve values for the current iteration
    $chost = isset($_POST["txtChost"][$i]) ? $conn->real_escape_string($_POST["txtChost"][$i]) : "";
    $volume = isset($_POST["txtVolume"][$i]) ? $conn->real_escape_string($_POST["txtVolume"][$i]) : "";
    $discount = isset($_POST["txtDiscount"][$i]) ? $conn->real_escape_string($_POST["txtDiscount"][$i]) : "";
    $comment = isset($_POST["txtComment"][$i]) ? $conn->real_escape_string($_POST["txtComment"][$i]) : "";
    $date = isset($_POST["txtDate"][$i]) ? $conn->real_escape_string($_POST["txtDate"][$i]) : "";

    // Skip insertion if date is empty
    if (empty($date)) {
        continue;
    }

    // Build the SQL query
    $sql = "INSERT INTO expense (chost, volume, discount, comment, expensecategory_id, date, expensesource_id, store_id) VALUES";
    $sql .= "('$chost', $volume, '$discount', '$comment', $expensecategory_id, '$date', $expensesource_id, $store_id)";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Record inserted successfully, but don't output anything here
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Debugging statement
echo "Debug: Iteration $i - chost: $chost, volume: $volume, discount: $discount, comment: $comment, date: $date<br>";



$conn->close();

// Function to add expense category if it doesn't exist and return its ID
function addExpenseCategory($conn) {
    if ($_POST["txtExpensecategory_id"] === '__new__') {
        // Insert a new record for expense category
        $expensecategory_name = $conn->real_escape_string($_POST["txtExpensecategoryName"]);
        return insertNewRecord($conn, 'expensecategory', 'expensecategory_name', $expensecategory_name);
    } elseif (!empty($_POST["txtExpensecategory_id"])) {
        return $conn->real_escape_string($_POST["txtExpensecategory_id"]);
    } else {
        return "NULL"; // Assuming expensecategory_id is nullable, adjust if necessary
    }
}

// Function to add store if it doesn't exist and return its ID
function addExpenseSource($conn) {
    if ($_POST["txtExpensesource_id"] === '__new__') {
        // Insert a new record for store
        $expensesource_name = $conn->real_escape_string($_POST["txtExpensesourceName"]);
        return insertNewRecord($conn, 'expensesource', 'expensesource_name', $expensesource_name);
    } elseif (!empty($_POST["txtExpensesource_id"])) {
        return $conn->real_escape_string($_POST["txtExpensesource_id"]);
    } else {
        return "NULL"; // Assuming store_id is nullable, adjust if necessary
    }
}

// Function to add store if it doesn't exist and return its ID
function addStore($conn) {
    if ($_POST["txtStore_id"] === '__new__') {
        // Insert a new record for store
        $store_name = $conn->real_escape_string($_POST["txtStoreName"]);
        return insertNewRecord($conn, 'store', 'store_name', $store_name);
    } elseif (!empty($_POST["txtStore_id"])) {
        return $conn->real_escape_string($_POST["txtStore_id"]);
    } else {
        return "NULL"; // Assuming store_id is nullable, adjust if necessary
    }
}

// Function to insert a new record into the specified table
function insertNewRecord($conn, $table, $column, $value) {
    $value = $conn->real_escape_string($value);
    $insertSql = "INSERT INTO $table ($column) VALUES ('$value')";
    if ($conn->query($insertSql) === TRUE) {
        return $conn->insert_id;
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
        return null;
    }
}
?>
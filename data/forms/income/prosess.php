<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';

// Default repeat count to 1 if not set or empty
$repeatCount = isset($_POST["repeatCount"]) && $_POST["repeatCount"] !== '' ? (int)$_POST["repeatCount"] : 1;

// Handle adding new income category and source only once
$incomecategory_id = addIncomeCategory($conn);
$incomesource_id = addIncomeSource($conn);

// Loop through each item to handle multiple submissions if necessary
for ($i = 0; $i < $repeatCount; $i++) {
    // Retrieve values for the current iteration
    $amount = isset($_POST["txtAmount"][$i]) ? $conn->real_escape_string($_POST["txtAmount"][$i]) : "";
    $comment = isset($_POST["txtComment"][$i]) ? $conn->real_escape_string($_POST["txtComment"][$i]) : "";
    $date = isset($_POST["txtDate"][$i]) ? $conn->real_escape_string($_POST["txtDate"][$i]) : "";

    // Skip insertion if date is empty
    if (empty($date)) {
        continue;
    }

    // Build the SQL query
    $sql = "INSERT INTO income (amount, comment, incomecategory_id, date, incomesource_id) VALUES ";
    $sql .= "('$amount', '$comment', $incomecategory_id, '$date', $incomesource_id)";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Record inserted successfully, no need to output here
    } else {
        echo "Error on entry $i: " . $sql . "<br>" . $conn->error;
    }
}

require $_SERVER['DOCUMENT_ROOT'] . '/components/return.php';

$conn->close();

// Function to add income category if it doesn't exist and return its ID
function addIncomeCategory($conn) {
    if ($_POST["txtIncomecategory_id"] === '__new__') {
        // Insert a new record for income category
        $incomecategory_name = $conn->real_escape_string($_POST["txtIncomecategoryName"]);
        return insertNewRecord($conn, 'incomecategory', 'incomecategory_name', $incomecategory_name);
    } elseif (!empty($_POST["txtIncomecategory_id"])) {
        return $conn->real_escape_string($_POST["txtIncomecategory_id"]);
    } else {
        return "NULL"; // Assuming incomecategory_id is nullable, adjust if necessary
    }
}

// Function to add source if it doesn't exist and return its ID
function addIncomeSource($conn) {
    if ($_POST["txtIncomesource_id"] === '__new__') {
        // Insert a new record for source
        $incomesource_name = $conn->real_escape_string($_POST["txtIncomesourceName"]);
        return insertNewRecord($conn, 'incomesource', 'incomesource_name', $incomesource_name);
    } elseif (!empty($_POST["txtIncomesource_id"])) {
        return $conn->real_escape_string($_POST["txtIncomesource_id"]);
    } else {
        return "NULL"; // Assuming source_id is nullable, adjust if necessary
    }
}

// Function to insert a new record into the specified table
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
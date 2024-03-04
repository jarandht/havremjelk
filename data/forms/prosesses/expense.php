<?php
require '../../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_POST["submit"])) {
    // Assuming $conn is your database connection

    // Get the repeat count
    $repeatCount = isset($_POST["repeatCount"]) ? (int)$_POST["repeatCount"] : 1;

    for ($i = 0; $i < $repeatCount; $i++) {
        $chost = $conn->real_escape_string($_POST["txtChost"]);
        $volume = isset($_POST["txtVolume"]) && $_POST["txtVolume"] !== '' ? "'" . $conn->real_escape_string($_POST["txtVolume"]) . "'" : "NULL";
        $discount = $conn->real_escape_string($_POST["txtDiscount"]);
        $expensecategory_name = $conn->real_escape_string($_POST["txtExpensecategoryName"]);
        $expensesource_id = null;
        $store_id = null;

        // Check if the expensecategory exists, if not, insert it
        $expensecategory_id = getExpenseCategoryId($conn, null, $expensecategory_name);

        // Check if $expensecategory_id is null before using it in the SQL query
        if ($expensecategory_id !== null) {
            // Check if expensesource_id is a new entry
            if (isset($_POST["txtExpensesource_id"]) && $_POST["txtExpensesource_id"] === '__new__') {
                // Insert a new record for expensesource
                $expensesource_name = $conn->real_escape_string($_POST["txtExpensesourceName"]);
                $expensesource_id = insertNewRecord($conn, 'expensesource', 'expensesource_name', $expensesource_name);
            } elseif (isset($_POST["txtExpensesource_id"])) {
                $expensesource_id = $conn->real_escape_string($_POST["txtExpensesource_id"]);
            }

            // Check if store_id is a new entry
            if (isset($_POST["txtStore_id"]) && $_POST["txtStore_id"] === '__new__') {
                // Insert a new record for store
                $store_name = $conn->real_escape_string($_POST["txtStoreName"]);
                $store_id = insertNewRecord($conn, 'store', 'store_name', $store_name);
            } elseif (isset($_POST["txtStore_id"])) {
                $store_id = $conn->real_escape_string($_POST["txtStore_id"]);
            }

            $comment = isset($_POST["txtComment"]) ? $conn->real_escape_string($_POST["txtComment"]) : "";
            $date = isset($_POST["txtDate"]) ? $conn->real_escape_string($_POST["txtDate"]) : "";

            // Build the SQL query
            $sql = "INSERT INTO expense (chost, volume, discount, comment, expensecategory_id, date, expensesource_id, store_id) VALUES('$chost', $volume, '$discount', '$comment', $expensecategory_id, '$date', $expensesource_id, $store_id)";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // Record inserted successfully, but don't output anything here
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Handle the case where $expensecategory_id is null (e.g., an error occurred during insertion)
            echo "Error getting expense category ID.";
        }
    }
}

// Function to get the expensecategory_id for a given name
function getExpenseCategoryId($conn, $expensecategory_id, $expensecategory_name) {
    $expensecategory_name = $conn->real_escape_string($_POST["txtExpensecategoryName"]);

    // Check if the expensecategory_id is set and not empty
    if (!empty($expensecategory_id)) {
        return $expensecategory_id;
    }

    // Check if the expensecategory_name is set and not empty
    if (!empty($expensecategory_name)) {
        // Check if the expensecategory exists, if not, insert it
        $insertSql = "INSERT INTO expensecategory (expensecategory_name) VALUES ('$expensecategory_name')";
        if ($conn->query($insertSql) === TRUE) {
            return $conn->insert_id;
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
            return null;
        }
    }

    return null;
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
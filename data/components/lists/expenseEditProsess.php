<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if expense_id exists
    if (!isset($_POST['expense_id']) || empty($_POST['expense_id'])) {
        die("Expense ID is missing.");
    }

    $expense_id = intval($_POST['expense_id']);
    $chost = $_POST['txtChost'] ?? null;
    $expensesource_id = $_POST['txtExpensesource_id'] ?? null;
    $discount = $_POST['txtDiscount'] ?? null;
    $volume = $_POST['txtVolume'] ?? null;
    $comment = $_POST['txtComment'] ?? null;
    $date = $_POST['txtDate'] ?? null;
    $store_id = $_POST['txtStore_id'] ?? null;
    $expensecategory_id = $_POST['txtExpensecategory_id'] ?? null;

    // Ensure no output is sent before headers
    ob_start();

    // Update the expense in the database
    $sql = "UPDATE expense 
            SET chost = ?, expensesource_id = ?, discount = ?, volume = ?, comment = ?, date = ?, store_id = ?, expensecategory_id = ? 
            WHERE expense_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "didsissii",
            $chost,
            $expensesource_id,
            $discount,
            $volume,
            $comment,
            $date,
            $store_id,
            $expensecategory_id,
            $expense_id
        );

        if ($stmt->execute()) {
            header("Location: /lists/expense/expense.php");
            exit();
        } else {
            echo "Error updating expense: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    ob_end_flush(); // Ensure output buffering is closed properly
}
?>

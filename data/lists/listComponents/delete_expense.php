<?php
require '../components/creds.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteButton"])) {
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if any checkboxes are selected
    if (isset($_POST["selectedExpenses"]) && is_array($_POST["selectedExpenses"])) {
        $selectedExpenses = $_POST["selectedExpenses"];

        // Use prepared statement to avoid SQL injection
        $stmt = $conn->prepare("DELETE FROM expense WHERE expense_id = ?");
        $stmt->bind_param("i", $expenseId);

        foreach ($selectedExpenses as $expenseId) {
            $stmt->execute();
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();

    // Redirect back to the main page after deletion
    header("Location: index.php");
    exit();
} else {
    // Redirect to the main page if the form wasn't submitted
    header("Location: index.php");
    exit();
}
?>

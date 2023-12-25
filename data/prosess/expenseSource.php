<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["expensesource"])) {
        $sourceName = $_POST["expensesource"];

        // Check if $sourceName is not empty
        if (!empty($sourceName)) {
            // Insert the source into the 'expensesource' table
            $insertSourceSQL = "INSERT INTO expensesource (expensesource_name) VALUES (:expensesourceName)";
            $stmt = $conn->prepare($insertSourceSQL);
            $stmt->bindParam(':expensesourceName', $sourceName);
            $stmt->execute();

            // Redirect back to the referring page
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
            header("Location: $referer");
            exit();
        } else {
            // Handle the case where $sourceName is empty
            echo "Source name cannot be empty.";
        }
    } else {
        // Handle the case where "expensesource" key is not set in $_POST
        echo "Source key is not set in the POST data.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>
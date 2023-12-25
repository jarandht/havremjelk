<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $expensecategoryName = $_POST["expensecategory_name"]; // Update the variable name

        // Insert the category into the 'expensecategory' table
        $insertCategorySQL = "INSERT INTO expensecategory (expensecategory_name) VALUES (:expensecategoryName)";
        $stmt = $conn->prepare($insertCategorySQL);
        $stmt->bindParam(':expensecategoryName', $expensecategoryName);
        $stmt->execute();

        // Redirect back to the referring page
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        header("Location: $referer");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>

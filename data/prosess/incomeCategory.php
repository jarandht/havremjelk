<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $incomecategoryName = $_POST["incomecategory_name"];

        // Insert the category into the 'category' table
        $insertCategorySQL = "INSERT INTO incomecategory (incomecategory_name) VALUES (:incomecategoryName)";
        $stmt = $conn->prepare($insertCategorySQL);
        $stmt->bindParam(':incomecategoryName', $incomecategoryName);
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

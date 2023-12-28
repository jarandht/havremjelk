<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $storeName = $_POST["store"];

        // Check if $storeName is not empty before proceeding with the insertion
        if (!empty($storeName)) {
            // Insert the store into the 'store' table
            $insertStoreSQL = "INSERT INTO store (store_name) VALUES (:store)";
            $stmt = $conn->prepare($insertStoreSQL);
            $stmt->bindParam(':store', $storeName);
            $stmt->execute();
        }

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
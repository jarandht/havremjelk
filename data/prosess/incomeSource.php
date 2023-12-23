<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sourceName = $_POST["source"];

        // Insert the source into the 'incomesource' table
        $insertSourceSQL = "INSERT INTO incomesource (incomesource_name) VALUES (:sourceName)";
        $stmt = $conn->prepare($insertSourceSQL);
        $stmt->bindParam(':sourceName', $sourceName);
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

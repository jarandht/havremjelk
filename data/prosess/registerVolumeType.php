<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $volumeTypeName = $_POST["volumeType_name"]; // Corrected key name

        // Check if $volumeTypeName is not empty before proceeding with the insertion
        if (!empty($volumeTypeName)) {
            // Insert the volumeType into the 'volumeTypes' table
            $insertVolumeTypeSQL = "INSERT INTO volumeTypes (volumeType_name) VALUES (:volumeTypes)";
            $stmt = $conn->prepare($insertVolumeTypeSQL);
            $stmt->bindParam(':volumeTypes', $volumeTypeName);
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

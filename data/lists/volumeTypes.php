<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch volumeTypes data
$sqlVolumeTypesData = "SELECT id, volumeType_name FROM volumeTypes";
$volumeTypesDataResult = $conn->query($sqlVolumeTypesData);

// Delete volumeType entry
if (isset($_GET["deleteVolumeType"])) {
    $volumeTypeId = $conn->real_escape_string($_GET["deleteVolumeType"]);

    // Attempt to delete the volumeType entry
    $deleteResult = $conn->query("DELETE FROM volumeTypes WHERE id = '$volumeTypeId'");

    // Check if the delete query was successful
    if ($deleteResult) {
        // Redirect back to the referring page
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        header("Location: $referer");
        exit();
    } else {
        // Check if the error is related to foreign key constraint
        $error = $conn->error;
        if (strpos($error, 'foreign key constraint') !== false) {
            echo '<div class="error">Error: VolumeType is in use </div>';
        } else {
            echo '<div class="error">Error deleting volumeType entry: </div>' . $error;
        }
    }
}
?>

<?php require 'listComponents/listTop.php'; ?>

<table>
    <thead>
        <tr class="tableTH">
            <th class="listSortUp">VolumeType Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $volumeTypesDataResult->data_seek(0);

        while ($row = $volumeTypesDataResult->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["volumeType_name"]; ?></td>
                <td><a class="listedit" href="?editVolumeType=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteVolumeType=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php require 'listComponents/listBtm.php'; ?>
<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch year data
$sqlYearData = "SELECT id FROM years";
$yearData = $conn->query($sqlYearData);

// Delete year
if (isset($_GET["deleteYear"])) {
    $yearid = $conn->real_escape_string($_GET["deleteYear"]);

    // Attempt to delete the year
    $deleteResult = $conn->query("DELETE FROM years WHERE id = '$yearid'");

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
            echo '<div class="error">Error: Year is in use</div>';
        } else {
            echo '<div class="error">Error deleting year: </div>' . $error;
        }
    }
}
?>
<?php
require 'listComponents/listTop.php';
?>
<table>
    <thead>
        <tr class="tableTH">
            <th>Year Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $yearData->data_seek(0);

        while ($row = $yearData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["id"]; ?></td>
                <td><a class="listedit" href="?editYear=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteYear=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require 'listComponents/listBtm.php';
?>

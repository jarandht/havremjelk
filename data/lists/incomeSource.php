<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch incomeCategory data
$sqlIncomeSourceData = "SELECT id, incomesource_name FROM incomesource";
$incomeSourceData = $conn->query($sqlIncomeSourceData);

// Delete income category
if (isset($_GET["deleteIncomeSource"])) {
    $incomesourceid = $conn->real_escape_string($_GET["deleteIncomeSource"]);

    // Attempt to delete the income category
    $deleteResult = $conn->query("DELETE FROM incomesource WHERE id = '$incomesourceid'");

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
            echo '<div class="error">Error: Category is in use </div>';
        } else {
            echo '<div class="error">Error deleting income category: </div>' . $error;
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
            <th>Source Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $incomeSourceData->data_seek(0);

        while ($row = $incomeSourceData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["incomesource_name"]; ?></td>
                <td><a class="listedit" href="?editIncomeSource=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteIncomeSource=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require 'listComponents/listBtm.php';
?>
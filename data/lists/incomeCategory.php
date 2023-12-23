<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch incomeCategory data
$sqlIncomeCategoryData = "SELECT id, incomecategory_name FROM incomecategory";
$incomeCategoryData = $conn->query($sqlIncomeCategoryData);

// Delete income category
if (isset($_GET["deleteIncomeCategory"])) {
    $incomecategoryid = $conn->real_escape_string($_GET["deleteIncomeCategory"]);

    // Attempt to delete the income category
    $deleteResult = $conn->query("DELETE FROM incomecategory WHERE id = '$incomecategoryid'");

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
            <th>Category Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $incomeCategoryData->data_seek(0);

        while ($row = $incomeCategoryData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["incomecategory_name"]; ?></td>
                <td><a class="listedit" href="?editIncomeCategory=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteIncomeCategory=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require 'listComponents/listBtm.php';
?>
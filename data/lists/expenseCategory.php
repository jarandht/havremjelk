<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch expenseCategory data
$sqlExpenseCategoryData = "SELECT id, expensecategory_name FROM expensecategory";
$expenseCategoryData = $conn->query($sqlExpenseCategoryData);

// Delete expense category
if (isset($_GET["deleteExpenseCategory"])) {
    $expensecategoryid = $conn->real_escape_string($_GET["deleteExpenseCategory"]);

    // Attempt to delete the expense category
    $deleteResult = $conn->query("DELETE FROM expensecategory WHERE id = '$expensecategoryid'");

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
            echo '<div class="error">Error deleting expense category: </div>' . $error;
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
        $expenseCategoryData->data_seek(0);

        while ($row = $expenseCategoryData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["expensecategory_name"]; ?></td>
                <td><a class="listedit" href="?editExpenseCategory=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteExpenseCategory=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require 'listComponents/listBtm.php';
?>
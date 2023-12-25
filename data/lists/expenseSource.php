<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch expense source data
$sqlExpenseSourceData = "SELECT id, expensesource_name FROM expensesource";
$expenseSourceData = $conn->query($sqlExpenseSourceData);

// Delete expense source
if (isset($_GET["deleteExpenseSource"])) {
    $expensesourceid = $conn->real_escape_string($_GET["deleteExpenseSource"]);

    // Attempt to delete the expense source
    $deleteResult = $conn->query("DELETE FROM expensesource WHERE id = '$expensesourceid'");

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
            echo '<div class="error">Error: Source is in use</div>';
        } else {
            echo '<div class="error">Error deleting expense source: </div>' . $error;
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
        $expenseSourceData->data_seek(0);

        while ($row = $expenseSourceData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><?php echo $row["expensesource_name"]; ?></td>
                <td><a class="listedit" href="?editExpenseSource=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteExpenseSource=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require 'listComponents/listBtm.php';
?>
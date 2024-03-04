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
<?php require 'listComponents/listTop.php'; ?>
<table>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
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
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-expense-source-id="<?php echo $row["id"]; ?>"></span></td>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["expensesource_name"]; ?></td>
                <td><a class="listedit" href="?editExpenseSource=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteExpenseSource=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#deleteSelectedButton").on("click", function () {
            var selectedExpenseSources = $(".delete-checkbox:checked").map(function () {
                return $(this).data("expense-source-id");
            }).get();

            if (selectedExpenseSources.length > 0) {
                var confirmation = confirm("Are you sure you want to delete the selected expense sources?");
                if (confirmation) {
                    window.location.href = "?deleteExpenseSource=" + selectedExpenseSources.join(",");
                }
            } else {
                alert("Please select at least one expense source to delete.");
            }
        });

        $("#selectAllCheckbox").on("change", function () {
            var isChecked = $(this).prop("checked");
            $(".delete-checkbox").prop("checked", isChecked).change();
        });

        $(".delete-checkbox").on("change", function () {
            var anyCheckboxChecked = $(".delete-checkbox:checked").length > 0;

            if (anyCheckboxChecked) {
                $(".listNavigationDeff").css("display", "none");
                $(".listNavigationOnSelect").css("display", "flex");

                var selectedCount = $(".delete-checkbox:checked").length;
                if (selectedCount > 1) {
                    $("#editSelectedButton").css("display", "none");
                } else {
                    $("#editSelectedButton").css("display", "flex");
                }
            } else {
                $(".listNavigationDeff").css("display", "grid");
                $(".listNavigationOnSelect").css("display", "none");
                $("#editSelectedButton").css("display", "flex");
            }
        });
    });
</script>
<?php require 'listComponents/listBtm.php'; ?>

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
<?php require 'listComponents/listTop.php'; ?>
<table>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
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
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-expense-category-id="<?php echo $row["id"]; ?>"></span></td>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["expensecategory_name"]; ?></td>
                <td><a class="listedit" href="?editExpenseCategory=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteExpenseCategory=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#deleteSelectedButton").on("click", function () {
            var selectedExpenseCategories = $(".delete-checkbox:checked").map(function () {
                return $(this).data("expense-category-id");
            }).get();

            if (selectedExpenseCategories.length > 0) {
                var confirmation = confirm("Are you sure you want to delete the selected expense categories?");
                if (confirmation) {
                    window.location.href = "?deleteExpenseCategory=" + selectedExpenseCategories.join(",");
                }
            } else {
                alert("Please select at least one expense category to delete.");
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
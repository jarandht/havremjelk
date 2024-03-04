<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch expense data
$sqlExpenseData = "SELECT expense_id, date, chost, discount, expensesource_id, expensecategory_id, store_id, volume FROM expense ORDER BY expense_id DESC";
$expenseDataResult = $conn->query($sqlExpenseData);

// Check if the query was successful
if ($expenseDataResult === FALSE) {
    // Handle the error, e.g., by echoing the error message
    echo "Error: " . $conn->error;
    // You might want to log the error or handle it differently based on your requirements
} else {
    // Fetch all rows and store them in $expenseData
    $expenseData = $expenseDataResult->fetch_all(MYSQLI_ASSOC);

    // Free the result set
    $expenseDataResult->free();
}

// Fetch source data
$sqlExpenseSource = "SELECT expensesource_name, id FROM expensesource";
$expenseSourceResult = $conn->query($sqlExpenseSource);
$expenseSource = array();
while ($row = $expenseSourceResult->fetch_assoc()) {
    $expenseSource[$row['id']] = $row['expensesource_name'];
}

// Fetch expensecategory data
$sqlExpenseCategory = "SELECT expensecategory_name, id FROM expensecategory";
$expenseCategoryResult = $conn->query($sqlExpenseCategory);
$expenseCategory = array();
while ($row = $expenseCategoryResult->fetch_assoc()) {
    $expenseCategory[$row['id']] = $row['expensecategory_name'];
}

// Fetch store data
$sqlStore = "SELECT store_name, id FROM store";
$storeResult = $conn->query($sqlStore);
$stores = array();
while ($row = $storeResult->fetch_assoc()) {
    $stores[$row['id']] = $row['store_name'];
}

// Delete expense
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteExpense"])) {
    $expenseIds = explode(",", $_GET["deleteExpense"]);
    $expenseIds = array_map('intval', $expenseIds);
    $expenseIds = implode(",", $expenseIds);
    $conn->query("DELETE FROM expense WHERE expense_id IN ($expenseIds)");

    // Redirect back to the referring page
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    header("Location: $referer");
    exit();
}

// Close the database connection
$conn->close();
?>

<?php require 'listComponents/listTop.php'; ?>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
            <th>Chost</th>
            <th>Source</th>
            <th>Discount</th>
            <th>Volume</th>
            <th>Store</th>
            <th>Category</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expenseData as $row) { ?>
            <tr class="tableTD">
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-expense-id="<?php echo $row["expense_id"]; ?>"></span></td>
                <td><?php echo $row["expense_id"]; ?></td>
                <td class="chost-value" style="display: none;"><?php echo $row["chost"]; ?></td>
                <td><?php echo $row["chost"] . 'kr'; ?></td>
                <td><?php echo isset($expenseSource[$row["expensesource_id"]]) ? $expenseSource[$row["expensesource_id"]] : ''; ?></td>
                <td><?php echo $row["discount"]; ?></td>
                <td><?php echo $row["volume"]; ?></td>
                </td>           
                <td><?php echo isset($stores[$row["store_id"]]) ? $stores[$row["store_id"]] : ''; ?></td>
                <td><?php echo isset($expenseCategory[$row["expensecategory_id"]]) ? $expenseCategory[$row["expensecategory_id"]] : ''; ?></td>
                <td><?php echo $row["date"]; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#deleteSelectedButton").on("click", function () {
            var selectedExpenses = $(".delete-checkbox:checked").map(function () {
                return $(this).data("expense-id");
            }).get();

            if (selectedExpenses.length > 0) {
                var confirmation = confirm("Are you sure you want to delete the selected expenses?");
                if (confirmation) {
                    window.location.href = "?deleteExpense=" + selectedExpenses.join(",");
                }
            } else {
                alert("Please select at least one expense to delete.");
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
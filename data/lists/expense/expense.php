<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';

// Fetch expense data
$sqlExpenseData = "SELECT expense_id, date, chost, discount, expensesource_id, comment, expensecategory_id, store_id, volume FROM expense ORDER BY expense_id DESC";
$expenseDataResult = $conn->query($sqlExpenseData);
$expenseData = $expenseDataResult->fetch_all(MYSQLI_ASSOC);

// Fetch source, category, and store data
$expenseSource = [];
$expenseCategory = [];
$stores = [];

$sqlExpenseSource = "SELECT expensesource_name, id FROM expensesource";
$sqlExpenseCategory = "SELECT expensecategory_name, id FROM expensecategory";
$sqlStore = "SELECT store_name, id FROM store";

foreach ($conn->query($sqlExpenseSource) as $row) {
    $expenseSource[$row['id']] = $row['expensesource_name'];
}
foreach ($conn->query($sqlExpenseCategory) as $row) {
    $expenseCategory[$row['id']] = $row['expensecategory_name'];
}
foreach ($conn->query($sqlStore) as $row) {
    $stores[$row['id']] = $row['store_name'];
}

$conn->close();
?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/lists/listTop.php'; ?>
<thead>
    <tr class="tableTH">
        <th>#</th>
        <th>Chost</th>
        <th>Source</th>
        <th>Discount</th>
        <th>Volume</th>
        <th>Store</th>
        <th>Category</th>
        <th>Comment</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($expenseData as $row): ?>
        <tr class="tableTD">
            <td><?php echo $row["expense_id"]; ?></td>
            <td><?php echo $row["chost"] . ' kr'; ?></td>
            <td><?php echo $expenseSource[$row["expensesource_id"]] ?? ''; ?></td>
            <td><?php echo $row["discount"]; ?></td>
            <td><?php echo $row["volume"]; ?></td>
            <td><?php echo $stores[$row["store_id"]] ?? ''; ?></td>
            <td><?php echo $expenseCategory[$row["expensecategory_id"]] ?? ''; ?></td>
            <td><?php echo $row["comment"]; ?></td>
            <td><?php echo date('j F Y', strtotime($row["date"])); ?></td>
            <td>
                <button class="edit-expense-btn" data-expense='<?php echo json_encode($row); ?>'>Edit</button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>

<?php require "./expenseEdit.php"; ?>

<script>
    $(document).ready(function () {
        $(".edit-expense-btn").on("click", function () {
            var expenseData = $(this).data("expense");

            // Populate form
            $("#editExpenseForm input[name='expense_id']").val(expenseData.expense_id);
            $("#editExpenseForm input[name='txtChost']").val(expenseData.chost);
            $("#editExpenseForm select[name='txtExpensesource_id']").val(expenseData.expensesource_id);
            $("#editExpenseForm input[name='txtDiscount']").val(expenseData.discount);
            $("#editExpenseForm input[name='txtVolume']").val(expenseData.volume);
            $("#editExpenseForm input[name='txtComment']").val(expenseData.comment);
            $("#editExpenseForm input[name='txtDate']").val(expenseData.date);
            $("#editExpenseForm select[name='txtStore_id']").val(expenseData.store_id);
            $("#editExpenseForm select[name='txtExpensecategory_id']").val(expenseData.expensecategory_id);


            // Show form with absolute positioning
            $("#editExpenseForm").css({
                display: "grid",
                position: "absolute",
            });
        });

        // Close form
        $("#closeEditForm").on("click", function () {
            $("#editExpenseForm").css("display", "none");
        });
    });
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/lists/listBtm.php'; ?>

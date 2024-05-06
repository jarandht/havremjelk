<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch income data
$sqlIncomeData = "SELECT income_id, amount, date, incomesource_id, incomecategory_id FROM income";
$incomeDataResult = $conn->query($sqlIncomeData);

// Check if the query was successful
if ($incomeDataResult) {
    // Fetch all rows and store them in $incomeData
    $incomeData = $incomeDataResult->fetch_all(MYSQLI_ASSOC);

    // Free the result set
    $incomeDataResult->free();
} else {
    // Handle the error, e.g., by echoing the error message
    echo "Error: " . $conn->error;
    // You might want to log the error or handle it differently based on your requirements
}

// Fetch source data
$sqlIncomeSource = "SELECT incomesource_name, id FROM incomesource";
$incomeSourceResult = $conn->query($sqlIncomeSource);
$incomeSource = array();
while ($row = $incomeSourceResult->fetch_assoc()) {
    $incomeSource[$row['id']] = $row['incomesource_name'];
}

// Fetch incomecategory data
$sqlIncomeCategory = "SELECT incomecategory_name, id FROM incomecategory";
$incomeCategoryResult = $conn->query($sqlIncomeCategory);
$incomeCategory = array();
while ($row = $incomeCategoryResult->fetch_assoc()) {
    $incomeCategory[$row['id']] = $row['incomecategory_name'];
}

// Delete
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteIncome"])) {
    $incomeIds = explode(",", $_GET["deleteIncome"]);
    $incomeIds = array_map('intval', $incomeIds);
    $incomeIds = implode(",", $incomeIds);
    $conn->query("DELETE FROM income WHERE income_id IN ($incomeIds)");

    // Redirect back to the referring page
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    header("Location: $referer");
    exit();
} 
?>
<?php require 'listComponents/listTop.php'; ?>
<table>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
            <th>Amount</th>
            <th>Source</th>
            <th>Category</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($incomeData as $row) { ?>
            <tr class="tableTD">
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-income-id="<?php echo $row["income_id"]; ?>"></span></td>
                <td><?php echo $row["income_id"]; ?></td>
                <td><?php echo $row["amount"]; ?>kr</td>
                <td><?php echo isset($incomeSource[$row["incomesource_id"]]) ? $incomeSource[$row["incomesource_id"]] : ''; ?></td>
                <td><?php echo isset($incomeCategory[$row["incomecategory_id"]]) ? $incomeCategory[$row["incomecategory_id"]] : ''; ?></td>
                <td><?php echo date('j F Y', strtotime($row["date"])); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#deleteSelectedButton").on("click", function () {
            var selectedIncomes = $(".delete-checkbox:checked").map(function () {
                return $(this).data("income-id");
            }).get();

            if (selectedIncomes.length > 0) {
                var confirmation = confirm("Are you sure you want to delete the selected incomes?");
                if (confirmation) {
                    window.location.href = "?deleteIncome=" + selectedIncomes.join(",");
                }
            } else {
                alert("Please select at least one income to delete.");
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

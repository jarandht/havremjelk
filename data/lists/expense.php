<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch expense data
$sqlExpenseData = "SELECT expense_id, chost, discount, expensesource_id, expensecategory_id, day_id, date_id, month_id, year_id, store_id, volume, volumeTypes_id FROM expense";
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

// Fetch volumeTypes data
$sqlVolumeTypes = "SELECT id, volumeType_name FROM volumeTypes";
$volumeTypesResult = $conn->query($sqlVolumeTypes);
$volumeTypes = array();
while ($row = $volumeTypesResult->fetch_assoc()) {
    $volumeTypes[$row['id']] = $row['volumeType_name'];
}

// Fetch expensecategory data
$sqlExpenseCategory = "SELECT expensecategory_name, id FROM expensecategory";
$expenseCategoryResult = $conn->query($sqlExpenseCategory);
$expenseCategory = array();
while ($row = $expenseCategoryResult->fetch_assoc()) {
    $expenseCategory[$row['id']] = $row['expensecategory_name'];
}

// Fetch days data
$sqlDays = "SELECT day_name, id FROM days";
$daysResult = $conn->query($sqlDays);
$days = array();
while ($row = $daysResult->fetch_assoc()) {
    $days[$row['id']] = $row['day_name'];
}

// Fetch dates data
$sqlDates = "SELECT id FROM dates";
$datesResult = $conn->query($sqlDates);
$dates = array();
while ($row = $datesResult->fetch_assoc()) {
    $dates[$row['id']] = $row['id'];
}

// Fetch months data
$sqlMonths = "SELECT id, month_name FROM months";
$monthsResult = $conn->query($sqlMonths);
$months = array();
while ($row = $monthsResult->fetch_assoc()) {
    $months[$row['id']] = $row['month_name'];
}

// Fetch year data
$sqlYear = "SELECT id FROM years"; // assuming you have a column named 'year_name'
$yearResult = $conn->query($sqlYear);
$years = array();
while ($row = $yearResult->fetch_assoc()) {
    $years[$row['id']] = $row['id'];
}

// Fetch store data
$sqlStore = "SELECT store_name, id FROM store";
$storeResult = $conn->query($sqlStore);
$stores = array();
while ($row = $storeResult->fetch_assoc()) {
    $stores[$row['id']] = $row['store_name'];
}

// Delete expense
if (isset($_GET["deleteExpense"])) {
    $expenseid = $conn->real_escape_string($_GET["deleteExpense"]);
    $conn->query("DELETE FROM expense WHERE expense_id = '$expenseid'");

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
            <th class="listSortUp">Cost</th>
            <th>Source</th>
            <th>Discount</th>
            <th>Volume</th>
            <th>Store</th>
            <th>Category</th>
            <th>Day</th>
            <th>Date</th>
            <th>Month</th>
            <th>Year</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expenseData as $row) { ?>
            <tr class="tableTD">
                <td><?php echo $row["chost"]; ?>kr</td>
                <td><?php echo isset($expenseSource[$row["expensesource_id"]]) ? $expenseSource[$row["expensesource_id"]] : ''; ?></td>
                <td><?php echo $row["discount"]; ?></td>
                <td>
                    <?php 
                        echo isset($row["volume"]) ? $row["volume"] : ''; 
                        echo ' ';
                        echo isset($row["volumeTypes_id"]) ? $volumeTypes[$row["volumeTypes_id"]] : '';
                        ?>
                </td>           
                <td><?php echo isset($stores[$row["store_id"]]) ? $stores[$row["store_id"]] : ''; ?></td>
                <td><?php echo isset($expenseCategory[$row["expensecategory_id"]]) ? $expenseCategory[$row["expensecategory_id"]] : ''; ?></td>
                <td><?php echo isset($days[$row["day_id"]]) ? $days[$row["day_id"]] : ''; ?></td>
                <td><?php echo isset($dates[$row["date_id"]]) ? $dates[$row["date_id"]] : ''; ?></td>
                <td data-month-id="<?php echo $row["month_id"]; ?>">
                    <?php echo isset($months[$row["month_id"]]) ? $months[$row["month_id"]] : ''; ?>
                </td>                
                <td><?php echo isset($years[$row["year_id"]]) ? $years[$row["year_id"]] : ''; ?></td>
                <td><a class="listedit" href="?deleteExpense=<?php echo $row["expense_id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteExpense=<?php echo $row["expense_id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<?php require 'listComponents/listBtm.php'; ?>
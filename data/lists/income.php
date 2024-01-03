<?php
require '../components/creds.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch income data
$sqlIncomeData = "SELECT income_id, amount, incomesource_id, incomecategory_id, day_id, date_id, month_id, year_id FROM income";
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

// Delete income
if (isset($_GET["deleteIncome"])) {
    $incomeid = $conn->real_escape_string($_GET["deleteIncome"]);
    $conn->query("DELETE FROM income WHERE income_id = '$incomeid'");

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
            <th class="listSortUp">Amount</th>
            <th>Source</th>
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
        <?php foreach ($incomeData as $row) { ?>
            <tr class="tableTD">
                <td><?php echo $row["amount"]; ?>kr</td>
                <td><?php echo isset($incomeSource[$row["incomesource_id"]]) ? $incomeSource[$row["incomesource_id"]] : ''; ?></td>
                <td><?php echo isset($incomeCategory[$row["incomecategory_id"]]) ? $incomeCategory[$row["incomecategory_id"]] : ''; ?></td>
                <td><?php echo isset($days[$row["day_id"]]) ? $days[$row["day_id"]] : ''; ?></td>
                <td><?php echo isset($dates[$row["date_id"]]) ? $dates[$row["date_id"]] : ''; ?></td>
                <td><?php echo isset($months[$row["month_id"]]) ? $months[$row["month_id"]] : ''; ?></td>
                <td><?php echo isset($years[$row["year_id"]]) ? $years[$row["year_id"]] : ''; ?></td>
                <td><a class="listedit" href="?deleteIncome=<?php echo $row["income_id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteIncome=<?php echo $row["income_id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php require 'listComponents/listBtm.php'; ?>
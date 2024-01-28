<?php
require '../components/head.php';
require '../components/creds.php';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of available years from the database
$sqlYears = "SELECT id FROM years";
$yearsResult = $conn->query($sqlYears);

// Check for errors in the years query
if (!$yearsResult) {
    die("Years query failed: " . $conn->error);
}

$years = array();
while ($row = $yearsResult->fetch_assoc()) {
    $years[] = $row['id'];
}

// Determine the selected year from the dropdown or default to the highest year
$selectedYear = isset($_POST['selected_year']) ? $_POST['selected_year'] : max($years);

// Fetch months data for the selected year
$sqlMonths = "SELECT id, month_name FROM months";
$monthsResult = $conn->query($sqlMonths);

// Check for errors in months query
if (!$monthsResult) {
    die("Months query failed: " . $conn->error);
}

$months = array();
while ($row = $monthsResult->fetch_assoc()) {
    $months[$row['id']] = $row['month_name'];
}

// Fetch income categories data
$sqlIncomeCategories = "SELECT id, incomecategory_name FROM incomecategory";
$incomeCategoriesResult = $conn->query($sqlIncomeCategories);

// Check for errors in income categories query
if (!$incomeCategoriesResult) {
    die("Income categories query failed: " . $conn->error);
}

$incomeCategories = array();
while ($row = $incomeCategoriesResult->fetch_assoc()) {
    $incomeCategoryId = $row['id'];
    $incomeCategoryName = $row['incomecategory_name'];

    // Check if there is any income for the current category
    $sqlCheckIncome = "SELECT 1 FROM income WHERE year_id = $selectedYear AND incomecategory_id = $incomeCategoryId LIMIT 1";
    $checkIncomeResult = $conn->query($sqlCheckIncome);

    if ($checkIncomeResult->num_rows > 0) {
        $incomeCategories[$incomeCategoryId] = $incomeCategoryName;
    }
}

// Fetch expense categories data
$sqlExpenseCategories = "SELECT id, expensecategory_name FROM expensecategory";
$expenseCategoriesResult = $conn->query($sqlExpenseCategories);

// Check for errors in expense categories query
if (!$expenseCategoriesResult) {
    die("Expense categories query failed: " . $conn->error);
}

$expenseCategories = array();
while ($row = $expenseCategoriesResult->fetch_assoc()) {
    $expenseCategoryId = $row['id'];
    $expenseCategoryName = $row['expensecategory_name'];

    // Check if there is any expense for the current category
    $sqlCheckExpense = "SELECT 1 FROM expense WHERE year_id = $selectedYear AND expensecategory_id = $expenseCategoryId LIMIT 1";
    $checkExpenseResult = $conn->query($sqlCheckExpense);

    if ($checkExpenseResult->num_rows > 0) {
        $expenseCategories[$expenseCategoryId] = $expenseCategoryName;
    }
}

// Fetch expenses data for the selected year
$sqlExpenses = "SELECT month_id, expensecategory_id, chost FROM expense WHERE year_id = $selectedYear";
$expensesResult = $conn->query($sqlExpenses);

// Check for errors in expenses query
if (!$expensesResult) {
    die("Expenses query failed: " . $conn->error);
}

$expenses = array();
while ($row = $expensesResult->fetch_assoc()) {
    $expenses[$row['month_id']][$row['expensecategory_id']][] = $row['chost'];
}

// Fetch income data for the selected year
$sqlIncome = "SELECT month_id, incomecategory_id, amount FROM income WHERE year_id = $selectedYear";
$incomeResult = $conn->query($sqlIncome);

// Check for errors in income query
if (!$incomeResult) {
    die("Income query failed: " . $conn->error);
}

$income = array();
while ($row = $incomeResult->fetch_assoc()) {
    $income[$row['month_id']][$row['incomecategory_id']][] = $row['amount'];
}

// Arrays to store totals for total income and total expense per month
$totalIncomePerMonth = array();
$totalExpensePerMonth = array();

// Calculate total income per month
foreach ($months as $monthId => $monthName) {
    $totalIncomePerMonth[$monthId] = 0;

    foreach ($incomeCategories as $categoryId => $categoryName) {
        if (isset($income[$monthId][$categoryId]) && count($income[$monthId][$categoryId]) > 0) {
            $totalIncomePerMonth[$monthId] += array_sum(array_map('floatval', $income[$monthId][$categoryId]));
        }
    }
}

// Calculate total expense per month
foreach ($months as $monthId => $monthName) {
    $totalExpensePerMonth[$monthId] = 0;

    foreach ($expenseCategories as $categoryId => $categoryName) {
        if (isset($expenses[$monthId][$categoryId]) && count($expenses[$monthId][$categoryId]) > 0) {
            $totalExpensePerMonth[$monthId] += array_sum(array_map('floatval', $expenses[$monthId][$categoryId]));
        }
    }
}
$conn->close();
?>
<body>
    <main>
        <?php require '../nav/nav.php'; ?>
        <section class="home">
            <section class="content">
                <form id="yearForm" method="post">
                    <table class="yearOverviewTable">
                        <tr>
                            <th class="tableyear">
                                <div>
                                    <select name="selected_year" id="selected_year" onchange="document.getElementById('yearForm').submit()">
                                        <?php foreach ($years as $year) : ?>
                                            <option value="<?php echo $year; ?>" <?php echo ($selectedYear == $year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <th class="tablemonths"><?php echo $monthName; ?></th>
                            <?php endforeach; ?>
                            <th class="tablemonths">Average</th>
                            <th class="tablemonths">Total</th>
                        </tr>
                        <?php foreach ($incomeCategories as $categoryId => $categoryName) : ?>
                            <tr>
                                <th><?php echo $categoryName; ?></th>
                                <?php
                                $totalIncome = 0;
                                foreach ($months as $monthId => $monthName) : ?>
                                    <td class="<?php echo (isset($income[$monthId][$categoryId]) && count($income[$monthId][$categoryId]) > 0) ? 'tableincome' : ''; ?>">
                                        <?php
                                        if (isset($income[$monthId][$categoryId]) && count($income[$monthId][$categoryId]) > 0) {
                                            $result = array_sum(array_map('floatval', $income[$monthId][$categoryId]));
                                            echo number_format(round($result, 2), 0, '.', ' '), "kr";
                                            $totalIncome += $result;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="tableAvrageSumary"><?php echo ($totalIncome != 0) ? number_format(round($totalIncome / 12, 0), 0, '.', ' ') . "kr" : '-'; ?></td>
                                <td class="tableAvrageSumary"><?php echo ($totalIncome != 0) ? number_format(round($totalIncome, 2), 0, '.', ' ') . "kr" : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th class="tableRowSpcaer" colspan="13"></th>
                            <th class="tableRowSpcaer" colspan="2"></th>
                        </tr>
                        <?php foreach ($expenseCategories as $categoryId => $categoryName) : ?>
                            <tr>
                                <th><?php echo $categoryName; ?></th>
                                <?php
                                $totalExpense = 0;
                                foreach ($months as $monthId => $monthName) : ?>
                                    <td class="<?php echo (isset($expenses[$monthId][$categoryId]) && count($expenses[$monthId][$categoryId]) > 0) ? 'tableexpense' : ''; ?>">
                                        <?php
                                        if (isset($expenses[$monthId][$categoryId]) && count($expenses[$monthId][$categoryId]) > 0) {
                                            $result = array_sum(array_map('floatval', $expenses[$monthId][$categoryId]));
                                            echo number_format(round($result, 2), 0, '.', ' '), "kr";
                                            $totalExpense += $result;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="tableAvrageSumary"><?php echo ($totalExpense != 0) ? number_format(round($totalExpense / 12, 0), 0, '.', ' ') . "kr" : '-'; ?></td>
                                <td class="tableAvrageSumary"><?php echo ($totalExpense != 0) ? number_format(round($totalExpense, 2), 0, '.', ' ') . "kr" : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th class="tableRowSpcaer" colspan="13"></th>
                            <th class="tableRowSpcaer" colspan="2"></th>
                        </tr>
                        <tr>
                            <th>Total Income</th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <?php
                                $totalIncomeValue = round($totalIncomePerMonth[$monthId], 2);
                                $tdClass = ($totalIncomeValue != 0) ? 'tableincome' : '';
                                ?>
                                <td class="<?php echo $tdClass; ?>"><?php echo ($totalIncomeValue != 0) ? number_format($totalIncomeValue, 0, '.', ' ') . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomePerMonth) != 0) ? number_format(round(array_sum($totalIncomePerMonth) / 12, 0), 0, '.', ' ') . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomePerMonth) != 0) ? number_format(round(array_sum($totalIncomePerMonth), 2), 0, '.', ' ') . "kr" : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Total Expense</th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <?php
                                $totalExpenseValue = round($totalExpensePerMonth[$monthId], 2);
                                $tdClass = ($totalExpenseValue != 0) ? 'tableexpense' : '';
                                ?>
                                <td class="<?php echo $tdClass; ?>"><?php echo ($totalExpenseValue != 0) ? number_format($totalExpenseValue, 0, '.', ' ') . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalExpensePerMonth) != 0) ? number_format(round(array_sum($totalExpensePerMonth) / 12, 0), 0, '.', ' ') . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalExpensePerMonth) != 0) ? number_format(round(array_sum($totalExpensePerMonth), 2), 0, '.', ' ') . "kr" : '-'; ?></td>
                        </tr>
                        <tr>
                            <th class="tableRowSpcaer" colspan="1"></th>
                            <th class="tableRowSpcaer" colspan="12"></th>
                            <th class="tableRowSpcaer" colspan="2"></th>
                        </tr>
                        <tr>
                            <th>Income - Expense</th>
                            <?php
                            $totalIncomeExpenseDiff = array();
                            foreach ($months as $monthId => $monthName) {
                                $totalIncomeExpenseDiff[$monthId] = round($totalIncomePerMonth[$monthId] - $totalExpensePerMonth[$monthId], 2);
                            }
                            ?>
                            <?php foreach ($totalIncomeExpenseDiff as $monthId => $diff) : ?>
                                <?php
                                $tdClass = ($diff < 0) ? 'tableexpense' : (($diff > 0) ? 'tableincome' : ''); // Add empty string if value is zero
                                ?>
                                <td class="<?php echo $tdClass; ?>"><?php echo ($diff != 0) ? number_format($diff, 0, '.', ' ') . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomeExpenseDiff) != 0) ? number_format(round(array_sum($totalIncomeExpenseDiff) / 12, 0), 0, '.', ' ') . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomeExpenseDiff) != 0) ? number_format(round(array_sum($totalIncomeExpenseDiff), 2), 0, '.', ' ') . "kr" : '-'; ?></td>
                        </tr>
                    </table>
                </form>
            </section>
        </section>
    </main>
</body>
</html>
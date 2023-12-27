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
    $incomeCategories[$row['id']] = $row['incomecategory_name'];
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
    $expenseCategories[$row['id']] = $row['expensecategory_name'];
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
        <?php require '../components/nav.php'; ?>
        <section class="home">
            <h1>Table</h1>
            <section class="content">
                <form id="yearForm" method="post">
                    <table class="yearOverviewTable">
                        <tr>
                            <th colspan="16" class="tableyear">
                                <div>
                                    <select name="selected_year" id="selected_year" onchange="document.getElementById('yearForm').submit()">
                                        <?php foreach ($years as $year) : ?>
                                            <option value="<?php echo $year; ?>" <?php echo ($selectedYear == $year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <th><?php echo $monthName; ?></th>
                            <?php endforeach; ?>
                            <th>Average</th>
                            <th>Total</th>
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
                                            echo round($result, 2), "kr";
                                            $totalIncome += $result;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="tableAvrageSumary"><?php echo ($totalIncome != 0) ? round($totalIncome / 12, 0) . "kr" : '-'; ?></td>
                                <td class="tableAvrageSumary"><?php echo ($totalIncome != 0) ? round($totalIncome, 2) . "kr" : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="13"></th>
                            <th colspan="2"></th>
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
                                            echo round($result, 2), "kr";
                                            $totalExpense += $result;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="tableAvrageSumary"><?php echo ($totalExpense != 0) ? round($totalExpense / 12, 0) . "kr" : '-'; ?></td>
                                <td class="tableAvrageSumary"><?php echo ($totalExpense != 0) ? round($totalExpense, 2) . "kr" : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="13"></th>
                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th>Total Income</th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <td><?php echo ($totalIncomePerMonth[$monthId] != 0) ? round($totalIncomePerMonth[$monthId], 2) . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomePerMonth) != 0) ? round(array_sum($totalIncomePerMonth) / 12, 0) . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomePerMonth) != 0) ? round(array_sum($totalIncomePerMonth), 2) . "kr" : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Total Expense</th>
                            <?php foreach ($months as $monthId => $monthName) : ?>
                                <td><?php echo ($totalExpensePerMonth[$monthId] != 0) ? round($totalExpensePerMonth[$monthId], 2) . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalExpensePerMonth) != 0) ? round(array_sum($totalExpensePerMonth) / 12, 0) . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalExpensePerMonth) != 0) ? round(array_sum($totalExpensePerMonth), 2) . "kr" : '-'; ?></td>
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
                                <td><?php echo ($diff != 0) ? $diff . "kr" : '-'; ?></td>
                            <?php endforeach; ?>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomeExpenseDiff) != 0) ? round(array_sum($totalIncomeExpenseDiff) / 12, 0) . "kr" : '-'; ?></td>
                            <td class="tableAvrageSumary"><?php echo (array_sum($totalIncomeExpenseDiff) != 0) ? round(array_sum($totalIncomeExpenseDiff), 2) . "kr" : '-'; ?></td>
                        </tr>
                    </table>
                </form>
            </section>
        </section>
    </main>
</body>
</html>

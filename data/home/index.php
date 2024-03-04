<?php
require '../components/creds.php';
require '../components/head.php';

// Function to calculate total amount for a specific category and year
function calculateTotal($conn, $table, $amountColumn, $dateColumn, $yearId = null)
{
    $yearCondition = $yearId ? "AND YEAR($dateColumn) = $yearId" : "";
    $totalSQL = "SELECT COALESCE(SUM($amountColumn), 0) as total FROM $table WHERE 1=1 $yearCondition";
    $totalResult = $conn->query($totalSQL);

    if ($totalResult !== false) {
        $totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
        return $totalRow['total'];
    } else {
        $errorInfo = $conn->errorInfo();
        throw new Exception("Error calculating total for $table: " . implode(", ", $errorInfo));
    }
}

try {
    // Create a connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Calculate total income
    $totalIncomeSQL = "SELECT COALESCE(SUM(amount), 0) as totalIncome FROM income";
    $totalIncomeResult = $conn->query($totalIncomeSQL);

    if ($totalIncomeResult !== false) {
        $totalIncomeRow = $totalIncomeResult->fetch(PDO::FETCH_ASSOC);
        $totalIncome = $totalIncomeRow['totalIncome'];
    } else {
        $totalIncome = 0;  // Set total income to 0 in case of an error
        $errorInfo = $conn->errorInfo();
        // Log the error or handle it as needed
        error_log("Error calculating total income: " . implode(", ", $errorInfo));
    }

    // Calculate total expenses
    $totalExpenses = calculateTotal($conn, 'expense', 'chost', 'date');

    // Get distinct years from the 'date' column of the 'income' table
    $distinctYearsIncomeSQL = "SELECT DISTINCT YEAR(date) as year FROM income";
    $distinctYearsExpenseSQL = "SELECT DISTINCT YEAR(date) as year FROM expense";

    $distinctYearsResultIncome = $conn->query($distinctYearsIncomeSQL);
    $distinctYearsResultExpense = $conn->query($distinctYearsExpenseSQL);

    // Combine distinct years from both income and expense tables
    $distinctYears = [];

    if ($distinctYearsResultIncome !== false) {
        while ($yearRow = $distinctYearsResultIncome->fetch(PDO::FETCH_ASSOC)) {
            $distinctYears[$yearRow['year']] = $yearRow['year'];
        }
    }

    if ($distinctYearsResultExpense !== false) {
        while ($yearRow = $distinctYearsResultExpense->fetch(PDO::FETCH_ASSOC)) {
            $distinctYears[$yearRow['year']] = $yearRow['year'];
        }
    }

    // Sort the distinct years in descending order
    arsort($distinctYears);

    // Store year-wise totals in an associative array
    $yearlyTotals = [];

    foreach ($distinctYears as $yearId) {
        $totalIncomeYear = calculateTotal($conn, 'income', 'amount', 'date', $yearId);
        $totalExpensesYear = calculateTotal($conn, 'expense', 'chost', 'date', $yearId);

        $yearlyTotals[$yearId] = [
            'income' => $totalIncomeYear,
            'expenses' => $totalExpensesYear,
        ];
    }

    // Calculate top 10 most valuable income categories
    $topIncomeCategoriesSQL = "SELECT ic.incomecategory_name, COALESCE(SUM(i.amount), 0) as totalIncome
                                FROM income i
                                JOIN incomecategory ic ON i.incomecategory_id = ic.id
                                GROUP BY ic.incomecategory_name
                                ORDER BY totalIncome DESC LIMIT 10";

    $topIncomeCategoriesResult = $conn->query($topIncomeCategoriesSQL);

    // Store top income categories in an associative array
    $topIncomeCategories = [];

    if ($topIncomeCategoriesResult !== false) {
        while ($incomeCategoryRow = $topIncomeCategoriesResult->fetch(PDO::FETCH_ASSOC)) {
            $category = $incomeCategoryRow['incomecategory_name'];
            $categoryTotalIncome = $incomeCategoryRow['totalIncome'];
            $topIncomeCategories[] = [
                'category' => $category,
                'totalIncome' => $categoryTotalIncome,
            ];
        }

    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error fetching top income categories: " . implode(", ", $errorInfo) . "</p>";
        die(); // Stop execution to examine the error
    }

    // Calculate top 10 most valuable income categories with total income
    $topIncomeCategoriesSQL = "SELECT ic.incomecategory_name, SUM(i.amount) as totalIncome
    FROM income i
    JOIN incomecategory ic ON i.incomecategory_id = ic.id
    GROUP BY ic.incomecategory_name
    WITH ROLLUP
    ORDER BY totalIncome DESC LIMIT 11";

    $topIncomeCategoriesResult = $conn->query($topIncomeCategoriesSQL);

    // Calculate top 10 most valuable expense categories
    $topExpenseCategoriesSQL = "SELECT ec.expensecategory_name, COALESCE(SUM(e.chost), 0) as totalExpense
                                FROM expense e
                                JOIN expensecategory ec ON e.expensecategory_id = ec.id
                                GROUP BY ec.expensecategory_name
                                ORDER BY totalExpense DESC LIMIT 10";

    $topExpenseCategoriesResult = $conn->query($topExpenseCategoriesSQL);

    // Store top expense categories in an associative array
    $topExpenseCategories = [];

    if ($topExpenseCategoriesResult !== false) {
        while ($expenseCategoryRow = $topExpenseCategoriesResult->fetch(PDO::FETCH_ASSOC)) {
            $category = $expenseCategoryRow['expensecategory_name'];
            $totalExpense = $expenseCategoryRow['totalExpense'];
            $topExpenseCategories[] = [
                'category' => $category,
                'totalExpense' => $totalExpense,
            ];
        }
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error fetching top expense categories: " . implode(", ", $errorInfo) . "</p>";
        die(); // Stop execution to examine the error
    }

} catch (PDOException $e) {
    echo "<p class='widgetContent'>Connection failed: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p class='widgetContent'>" . $e->getMessage() . "</p>";
} finally {
    // Close the connection
    $conn = null;
}
?>

<!-- ... (your existing code) ... -->

<body>
    <main>
        <?php require '../nav/nav.php'; ?>
        <section class="home">
            <section class="content">
                <section class="widgetCategory">
                    <h2>Total</h2>
                    <div class="widgets">
                        <div class="widget" id="income">
                            <div>
                                <p class="widgetTitle">total income</p>
                                <p class="widgetContent"><?= number_format($totalIncome, 0, '', ' ') ?>kr</p>
                            </div>
                            <div class="widgetIndicator"></div>
                        </div>
                        <div class="widget" id="expense">
                            <div>
                                <p class="widgetTitle">total expenses</p>
                                <p class="widgetContent"><?= number_format($totalExpenses, 0, '', ' ') ?>kr</p>
                            </div>
                            <div class="widgetIndicator"></div>
                        </div>
                    </div>
                </section>




                <section class="widgetCategory">
                    <h2>Yearly Income Totals</h2>
                    <div class="widgets">
                        <?php foreach ($yearlyTotals as $yearId => $totals) : ?>
                            <div class="widget" id="income">
                                <div>
                                    <p class="widgetTitle"><?= $yearId ?> Income</p>
                                    <p class="widgetContent"><?= number_format($totals['income'], 0, '', ' ') ?>kr</p>
                                </div>
                                <div class="widgetIndicator"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="widgetCategory">
                    <h2>Yearly Expense Totals</h2>
                    <div class="widgets">
                        <?php foreach ($yearlyTotals as $yearId => $totals) : ?>
                            <div class="widget" id="expense">
                                <div>
                                    <p class="widgetTitle"><?= $yearId ?> Expenses</p>
                                    <p class="widgetContent"><?= number_format($totals['expenses'], 0, '', ' ') ?>kr</p>
                                </div>
                                <div class="widgetIndicator"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>




                <section class="widgetCategory">
                    <h2>Top 10 Income Categories</h2>
                    <div class="widgets">
                        <?php if (!empty($topIncomeCategories)) : ?>
                            <?php foreach ($topIncomeCategories as $incomeCategory) : ?>
                                <div class="widget" id="income">
                                    <div>
                                        <p class="widgetTitle"><?= $incomeCategory['category'] ?></p>
                                        <p class="widgetContent"><?= number_format($incomeCategory['totalIncome'], 0, '', ' ') ?>kr</p>
                                    </div>
                                    <div class="widgetIndicator"></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="widgetContent">No income categories found.</p>
                        <?php endif; ?>
                    </div>
                </section>
                <section class="widgetCategory">
                    <h2>Top 10 Expense Categories</h2>
                    <div class="widgets">
                        <?php if (!empty($topExpenseCategories)) : ?>
                            <?php foreach ($topExpenseCategories as $expenseCategory) : ?>
                                <div class="widget" id="expense">
                                    <div>
                                        <p class="widgetTitle"><?= $expenseCategory['category'] ?></p>
                                        <p class="widgetContent"><?= number_format($expenseCategory['totalExpense'], 0, '', ' ') ?>kr</p>
                                    </div>
                                    <div class="widgetIndicator"></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="widgetContent">No expense categories found.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </section>
        </section>
    </main>
</body>
</html>

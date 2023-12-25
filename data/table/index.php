<?php
require '../components/head.php';
require '../components/creds.php';

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch months data
$sqlMonths = "SELECT id, month_name FROM months";
$monthsResult = $conn->query($sqlMonths);
$months = array();
while ($row = $monthsResult->fetch_assoc()) {
    $months[$row['id']] = $row['month_name'];
}

// Fetch expenses data
$sqlExpenses = "SELECT month_id, chost FROM expense";
$expensesResult = $conn->query($sqlExpenses);
$expenses = array();
while ($row = $expensesResult->fetch_assoc()) {
    $expenses[$row['month_id']][] = $row['chost'];
}

// Debugging: Output the fetched expenses
echo '<pre>';
print_r($expenses);
echo '</pre>';

$conn->close();
?>

<body>
    <main>
        <?php require '../components/nav.php'; ?>
        <section class="home">
            <h1>Table</h1>
            <section class="content">
                <table class="yearOverviewTable">
                    <tr>
                        <th>Month</th>
                        <?php foreach ($months as $monthId => $monthName) : ?>
                            <td><?php echo $monthName; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th>Chost</th>
                        <?php foreach ($months as $monthId => $monthName) : ?>
                            <td>
                                <?php
                                if (isset($expenses[$monthId]) && !empty($expenses[$monthId])) {
                                    // Display expenses for the corresponding month
                                    echo implode(', ', $expenses[$monthId]);
                                } else {
                                    echo '-'; // No expenses for this month
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </section>
        </section>
    </main>
</body>
</html>
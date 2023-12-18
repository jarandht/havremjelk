<?php
require '../components/creds.php';
require '../components/head.php';

$conn = new mysqli($servername, $username, $password, $database);

// Fetch income data
$incomeData = $conn->query("SELECT income_id, chost, source_id, incomecategory_id, day_id, date_id, month_id, year_id FROM income");

// Fetch source data
$sqlincomeData_source = "SELECT source_name, id FROM source";
$incomeData_source = $conn->query($sqlincomeData_source);
$income_source = array();
while ($row = mysqli_fetch_array($incomeData_source)) {
    $income_source[$row['id']] = $row['source_name'];
}

// Fetch incomecategory data
$sqlincomeData_incomecategory = "SELECT incomecategory_name, id FROM incomecategory";
$incomeData_incomecategory = $conn->query($sqlincomeData_incomecategory);
$income_incomecategory = array();
while ($row = mysqli_fetch_array($incomeData_incomecategory)) {
    $income_incomecategory[$row['id']] = $row['incomecategory_name'];
}

// Fetch days data
$sqlincomeData_days = "SELECT day_name, id FROM days";
$days_result = $conn->query($sqlincomeData_days);
$incomeData_days = array();
while ($row = mysqli_fetch_array($days_result)) {
    $incomeData_days[$row['id']] = $row['day_name'];
}

// Fetch dates data
$sqlincomeData_dates = "SELECT id FROM dates";
$dates_result = $conn->query($sqlincomeData_dates);
$incomeData_dates = array();
while ($row = mysqli_fetch_array($dates_result)) {
    $incomeData_dates[$row['id']] = $row['id'];
}

// Fetch months data
$sqlincomeData_months = "SELECT id, month_name FROM months";
$months_result = $conn->query($sqlincomeData_months);
$incomeData_months = array();
while ($row = mysqli_fetch_array($months_result)) {
    $incomeData_months[$row['id']] = $row['month_name'];
}

// Fetch year data
$sqlincomeData_year = "SELECT id FROM years";
$year_result = $conn->query($sqlincomeData_year);
$incomeData_year = array();
while ($row = mysqli_fetch_array($year_result)) {
    $incomeData_year[$row['id']] = $row['id'];
}

// Delete income
if (isset($_GET["deleteIncome"])) {
    $incomeid = $conn->real_escape_string($_GET["deleteIncome"]);
    $conn->query("DELETE FROM income WHERE income_id = '$incomeid'");
}


?>
<body>

<main>
    <?php
    require '../components/nav.php';
    ?>
    <section class="home">
        <h1>Lists</h1>
        <section class="listContent">
            <div class="listSources">
                <div>Income</div>
                <div>Income Categories</div>
                <div>Income Sources</div>
                <div>Expenses</div>
                <div>Expenses Categories</div>
                <div>Expense Product</div>
            </div>
            <div class="listSearch">
                <input type="search" placeholder="search" id="searchInput">
            </div>
            <div class="listTable">
                <table>
                    <thead>
                        <tr class="tableTH">
                            <th>Prize</th>
                            <th>Source</th>
                            <th>Category</th>
                            <th>Day</th>
                            <th>Date</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rad = mysqli_fetch_array($incomeData)) { ?>
                            <tr class="tableTD">
                                <td><?php echo $rad["chost"]; ?>kr</td>
                                <td><?php echo isset($income_source[$rad["source_id"]]) ? $income_source[$rad["source_id"]] : ''; ?></td>
                                <td><?php echo isset($income_incomecategory[$rad["incomecategory_id"]]) ? $income_incomecategory[$rad["incomecategory_id"]] : ''; ?></td>
                                <td><?php echo isset($incomeData_days[$rad["day_id"]]) ? $incomeData_days[$rad["day_id"]] : ''; ?></td>
                                <td><?php echo isset($incomeData_dates[$rad["date_id"]]) ? $incomeData_dates[$rad["date_id"]] : ''; ?></td>
                                <td><?php echo isset($incomeData_months[$rad["month_id"]]) ? $incomeData_months[$rad["month_id"]] : ''; ?></td>
                                <td><?php echo isset($incomeData_year[$rad["year_id"]]) ? $incomeData_year[$rad["year_id"]] : ''; ?></td>
                                <td><a class="slett" href="?deleteIncome=<?php echo $rad["income_id"]; ?>">Edit</a></td>
                                <td><a class="slett" href="?deleteIncome=<?php echo $rad["income_id"]; ?>">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchInput").on("input", function () {
            var searchText = $(this).val().toLowerCase();

            // Iterate over each row in the table body
            $(".listTable tbody tr").each(function () {
                var rowText = $(this).text().toLowerCase();

                // Show or hide the row based on the search text
                $(this).toggle(rowText.includes(searchText));
            });
        });
    });
</script>
</body>
</html>

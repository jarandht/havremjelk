<?php
require 'creds.php';

$conn = new mysqli($servername, $username, $password, $database);

$sqlexpensecategory = "SELECT id, expensecategory_name FROM expensecategory";
$expensecategory = $conn->query($sqlexpensecategory);
$sqlexpensesource = "SELECT id, expensesource_name FROM expensesource";
$expensesource = $conn->query($sqlexpensesource);
$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);
$sqldate = "SELECT id, id FROM dates";
$date = $conn->query($sqldate);
$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);
$sqlstore = "SELECT id, store_name FROM store";
$store = $conn->query($sqlstore);
$sqlyear = "SELECT id, id FROM years";
$year = $conn->query($sqlyear);

$conn->close();
?>

<!-- expense form -->
<div class="floatingForm" id="expenseForm">
    <form class="data" method="post" action="/prosess/expense.php" onsubmit="registerExpense(event)">
        <span>
            <h2>register expense</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpense()">
        </span>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Cost</p></label>
            <input type="number" name="txtChost" id="txtChost" require />
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Category</p><img onclick="registerExpenseCategory(); registerExpense();" src="/img/pluss.png" alt=""></label>
            <select name="txtExpensecategory_id" id="txtExpensecategory_id" require>
                <?php while ($rowExpensecategory = mysqli_fetch_array($expensecategory)) {
                    echo "<option value='{$rowExpensecategory["id"]}'>{$rowExpensecategory["expensecategory_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Source</p><img onclick="registerExpenseSource(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtExpensesource_id" id="txtExpensesource_id">
                <option value="">Unknown</option>
                <?php while ($rowExpensesource = mysqli_fetch_array($expensesource)) {
                    echo "<option value='{$rowExpensesource["id"]}'>{$rowExpensesource["expensesource_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for=""><p>Store</p><img onclick="registerStore(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtStore_id" id="txtStore_id" require>
                <option value="">Unknown</option>
                <?php while ($rowStore = mysqli_fetch_array($store)) {
                    echo "<option value='{$rowStore["id"]}'>{$rowStore["store_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>Year</p><img onclick="registerYear(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtYear_id" id="txtYear_id" require>
                <?php while ($rowYear = mysqli_fetch_array($year)) {
                    echo "<option value='{$rowYear["id"]}'>{$rowYear["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>Month</p></label>
            <select name="txtMonth_id" id="txtMonth_id" require>
                <?php while ($rowMonth = mysqli_fetch_array($month)) {
                    echo "<option value='{$rowMonth["id"]}'>{$rowMonth["month_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>Date</p></label>
            <select name="txtDate_id" id="txtDate_id">
                <option value="">Unknown</option>
                <?php while ($rowDate = mysqli_fetch_array($date)) {
                    echo "<option value='{$rowDate["id"]}'>{$rowDate["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>Day</p></label>
            <select name="txtDay_id" id="txtDay_id">
                <option value="">Unknown</option>
                <?php while ($rowDay = mysqli_fetch_array($day)) {
                    echo "<option value='{$rowDay["id"]}'>{$rowDay["day_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- expense category -->
<div class="floatingForm" id="registerExpenseCategory">
    <form action="/prosess/expenseCategory.php" method="post" class="data">
        <span>
            <h2>add expense category</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpenseCategory()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="category"><p>Category</p></label>
            <input type="text" name="expensecategory_name">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- expense source -->
<div class="floatingForm" id="registerExpenseSource">
    <form action="/prosess/expenseSource.php" method="post" class="data">
        <span>
            <h2>add expense source</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpenseSource()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="expensesource"><p>Source</p></label>
            <input type="text" id="expensesource" name="expensesource">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- Store -->
<div class="floatingForm" id="registerStore">
    <form action="/prosess/registerStore.php" method="post" class="data">
        <span>
            <h2>Add Store</h2>
            <img src="/img/pluss.png" alt="" onclick="registerStore()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="store"><p>Store Name</p></label>
            <input type="text" id="store" name="store">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- Year -->
<div class="floatingForm" id="registerYear">
    <form action="/prosess/registerYear.php" method="post" class="data">
        <span>
            <h2>add year</h2>
            <img src="/img/pluss.png" alt="" onclick="registerYear()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="years"><p>Year</p></label>
            <input type="number" id="years" name="years">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<style>
    #expenseForm {
        display: none; /* Initially hidden */
    }
    #registerExpenseCategory {
        display: none; /* Initially hidden */
    }
    #registerExpenseSource {
        display: none; /* Initially hidden */
    }
    #registerStore {
        display: none; /* Initially hidden */
    }
    #registerYear {
        display: none; /* Initially hidden */
    }
</style>

<script>
    function registerExpense() {
        var element = document.getElementById("expenseForm");

        // Toggle between display block and none
        if (element.style.display === "flex") {
            element.style.display = "none";
        } else {
            element.style.display = "flex";
        }
    }

    function registerExpenseCategory() {
        var element = document.getElementById("registerExpenseCategory");

        // Toggle between display block and none
        if (element.style.display === "flex") {
            element.style.display = "none";
        } else {
            element.style.display = "flex";
        }
    }

    function registerExpenseSource() {
        var element = document.getElementById("registerExpenseSource");

        // Toggle between display block and none
        if (element.style.display === "flex") {
            element.style.display = "none";
        } else {
            element.style.display = "flex";
        }
    }

    function registerStore() {
        var element = document.getElementById("registerStore");

        // Toggle between display block and none
        if (element.style.display === "flex") {
            element.style.display = "none";
        } else {
            element.style.display = "flex";
        }
    }

    function registerYear() {
        var element = document.getElementById("registerYear");

        // Toggle between display block and none
        if (element.style.display === "flex") {
            element.style.display = "none";
        } else {
            element.style.display = "flex";
        }
    }
</script>
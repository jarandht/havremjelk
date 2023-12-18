<?php
require 'creds.php';

$conn = new mysqli($servername, $username, $password, $database);

$sqlincomecategory = "SELECT id, incomecategory_name FROM incomecategory";
$incomecategory = $conn->query($sqlincomecategory);
$sqlsource = "SELECT id, source_name FROM source";
$source = $conn->query($sqlsource);
$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);
$sqldate = "SELECT id, id FROM dates";
$date = $conn->query($sqldate);
$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);
$sqlyear = "SELECT id, id FROM years";
$year = $conn->query($sqlyear);

if (isset($_POST["submit"])) {
    // Check if the year_id is not empty before inserting into the database
    $year_id = !empty($_POST["txtYear_id"]) ? $conn->real_escape_string($_POST["txtYear_id"]) : null;

    // Repeat this check for other dropdowns

    $sql = sprintf("INSERT INTO income(chost, year_id, month_id, date_id, day_id, incomecategory_id, source_id) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $conn->real_escape_string($_POST["txtChost"]),
        $year_id,
        // Repeat this for other fields
    );
    $conn->query($sql);
}

$conn = null;

?>

<nav>
    <a href="/">
        <div>
            <img src="/img/home.png" alt="">
            <p>Home</p>
        </div>
    </a>
    <a href="/table">
        <div>
            <img src="/img/table.png" alt="">
            <p>Table</p>
        </div>
    </a>
    <div onclick="registerIncome()"*>
        <img src="/img/pluss.png" alt="">
        <p>Income</p>
    </div>
    <div onclick="registerIncome()"*>
        <img src="/img/pluss.png" alt="">
        <p>Expense</p>
    </div>
    <a href="/lists">
        <div>
            <img src="/img/list.png" alt="">
            <p>Lists</p>
        </div>
    </a>
    <a href="/settings">
        <div>
            <img src="/img/gear.png" alt="">
            <p>Settings</p>
        </div>
    </a>
</nav>

<!-- income form -->
<div class="floatingForm" id="incomeForm">
    <form class="data" method="post" action="" onsubmit="registerIncome(event)">
        <span>
            <h2>register income</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncome()"*>
        </span>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Chost</p></label>
            <input type="text" name="txtChost" id="txtChost" />
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Category</p><img onclick="registerIncomeCategory(); registerIncome();" src="/img/pluss.png" alt=""></label>
            <select name="txtIncomecategory_id" id="txtIncomecategory_id">
                <option value="">Unknown</option>
                <?php while ($rowIncomecategory = mysqli_fetch_array($incomecategory)) {
                    echo "<option value='{$rowIncomecategory["id"]}'>{$rowIncomecategory["incomecategory_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Source</p><img onclick="registerIncomeSource(), registerIncome()" src="/img/pluss.png" alt=""></label>
            <select name="txtSource_id" id="txtSource_id">
                <option value="">Unknown</option>
                <?php while ($rowSource = mysqli_fetch_array($source)) {
                    echo "<option value='{$rowSource["id"]}'>{$rowSource["source_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>year</p></label>
            <select name="txtYear_id" id="txtYear_id">
                <?php while ($rowYear = mysqli_fetch_array($year)) {
                    echo "<option value='{$rowYear["id"]}'>{$rowYear["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>month</p></label>
            <select name="txtMonth_id" id="txtMonth_id">
                <?php while ($rowMonth = mysqli_fetch_array($month)) {
                    echo "<option value='{$rowMonth["id"]}'>{$rowMonth["month_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>date</p></label>
            <select name="txtDate_id" id="txtDate_id">
                <option value="">Unknown</option>
                <?php while ($rowDate = mysqli_fetch_array($date)) {
                    echo "<option value='{$rowDate["id"]}'>{$rowDate["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>day</p></label>
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
<div class="floatingForm" id="registerIncomeCategory">
    <form action="/prosess/incomeCategory.php" method="post" class="data">
        <span>
            <h2>add income category</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncomeCategory()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="category"><p>Category</p></label>
            <input type="text" name="incomecategory_name">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
<div class="floatingForm" id="registerIncomeSource">
    <form action="/prosess/incomeSource.php" method="post" class="data">
        <span>
            <h2>add income source</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncomeSource()">
        </span>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="source"><p>Source</p></label>
            <input type="text" id="source" name="source">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
<style>
    #incomeForm {
      display: none; /* Initially visible */
    }
    #registerIncomeCategory {
      display: none; /* Initially visible */
    }
    #registerIncomeSource {
      display: none; /* Initially visible */
    }
</style>
<script>
  function registerIncome() {
    var element = document.getElementById("incomeForm");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }
  function registerIncomeCategory() {
    var element = document.getElementById("registerIncomeCategory");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }
  function registerIncomeSource() {
    var element = document.getElementById("registerIncomeSource");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }
</script> 
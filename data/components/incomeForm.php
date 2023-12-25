<?php
require 'creds.php';

$conn = new mysqli($servername, $username, $password, $database);

$sqlincomecategory = "SELECT id, incomecategory_name FROM incomecategory";
$incomecategory = $conn->query($sqlincomecategory);
$sqlincomesource = "SELECT id, incomesource_name FROM incomesource";
$incomesource = $conn->query($sqlincomesource);
$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);
$sqldate = "SELECT id, id FROM dates";
$date = $conn->query($sqldate);
$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);
$sqlyear = "SELECT id, id FROM years";
$year = $conn->query($sqlyear);

$conn->close();

?>
<!-- income form -->
<div class="floatingForm" id="incomeForm">
    <form class="data" method="post" action="/prosess/income.php" onsubmit="registerIncome(event)">
        <span>
            <h2>register income</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncome()"*>
        </span>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Amount</p></label>
            <input type="number" name="txtAmount" id="txtAmount" require />
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Category</p><img onclick="registerIncomeCategory(); registerIncome();" src="/img/pluss.png" alt=""></label>
            <select name="txtIncomecategory_id" id="txtIncomecategory_id" require>
                <?php while ($rowIncomecategory = mysqli_fetch_array($incomecategory)) {
                    echo "<option value='{$rowIncomecategory["id"]}'>{$rowIncomecategory["incomecategory_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Source</p><img onclick="registerIncomeSource(), registerIncome()" src="/img/pluss.png" alt=""></label>
            <select name="txtIncomesource_id" id="txtIncomesource_id">
                <option value="">Unknown</option>
                <?php while ($rowIncomesource = mysqli_fetch_array($incomesource)) {
                    echo "<option value='{$rowIncomesource["id"]}'>{$rowIncomesource["incomesource_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>year</p><img onclick="registerYear(), registerIncome();" src="/img/pluss.png" alt=""></label>
            <select name="txtYear_id" id="txtYear_id" require>
                <?php while ($rowYear = mysqli_fetch_array($year)) {
                    echo "<option value='{$rowYear["id"]}'>{$rowYear["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails">
            <label for=""><p>month</p></label>
            <select name="txtMonth_id" id="txtMonth_id" require>
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
            <label for="incomesource"><p>Source</p></label>
            <input type="text" id="incomesource" name="incomesource">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
<div class="floatingForm" id="registerYear">
    <form action="/prosess/registerYear.php" method="post" class="data">
        <span>
            <h2>add income source</h2>
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
    #incomeForm {
      display: none; /* Initially visible */
    }
    #registerIncomeCategory {
      display: none; /* Initially visible */
    }
    #registerIncomeSource {
      display: none; /* Initially visible */
    }
    #registerYear{
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
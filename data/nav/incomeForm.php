<div class="floatingForm" id="incomeForm">
    <form class="data" method="post" action="/prosess/income.php" onsubmit="registerIncome(event)">
        <header style="grid-column: 1 / 3">
            <h2>income</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncome()"*>
        </header>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Amount</p></label>
            <input type="text" name="txtAmount" id="txtAmount" require />
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Category</p><img onclick="registerIncomeCategory(); registerIncome();" src="/img/pluss.png" alt=""></label>
            <select name="txtIncomecategory_id" id="txtIncomecategory_id " require>
                <?php while ($rowIncomecategory = mysqli_fetch_array($incomecategory)) {
                    echo "<option value='{$rowIncomecategory["id"]}'>{$rowIncomecategory["incomecategory_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 /3">
            <label for=""><p>Source</p><img onclick="registerIncomeSource(), registerIncome()" src="/img/pluss.png" alt=""></label>
            <select name="txtIncomesource_id" id="txtIncomesource_id" >
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
            <select name="txtMonth_id[]" id="txtMonth_id" required>
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
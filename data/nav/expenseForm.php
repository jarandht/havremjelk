<!-- expense form -->
<div class="floatingForm" id="expenseForm">
    <form class="data dataExpense" method="post" action="/prosess/expense.php" onsubmit="return registerExpense(event)">
        <header class="dataFormHeader" style="grid-column: 1 / 5">
            <h2>expense</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpense()">
        </header>
        <div class="dataOptions" style="grid-column: 1 / 3">
            <h3>Advanced: </h3>
            <label class="switch"><input type="checkbox" id="dataAddAdvancedSwitch"><span class="slider"></span></label>
        </div>
        <div class="dataOptions" style="grid-column: 3 / 5">
            <h3>Fixed expense: </h3>
            <label class="switch"><input type="checkbox" id="dataAddFixedTaskSwitch"><span class="slider"></span></label>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5" id="dataAddAdvanced">
            <label for="repeatCount"><p>Repeat Count</p></label>
            <input type="number" name="repeatCount" id="repeatCount" value="1" min="1" required />
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5">
            <label for="txtChost"><p>Cost</p></label>
            <input type="number" name="txtChost" id="txtChost" step="any" required />
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5" id="dataAddAdvanced">
            <label for="txtDiscount"><p>Discount</p></label>
            <input type="text" name="txtDiscount" id="txtDiscount"/>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5">
            <label for=""><p>Category</p><img onclick="registerExpenseCategory(); registerExpense();" src="/img/pluss.png" alt=""></label>
            <select name="txtExpensecategory_id" id="txtExpensecategory_id" require>
                <?php while ($rowExpensecategory = mysqli_fetch_array($expensecategory)) {
                    echo "<option value='{$rowExpensecategory["id"]}'>{$rowExpensecategory["expensecategory_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5">
            <label for=""><p>Source</p><img onclick="registerExpenseSource(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtExpensesource_id" id="txtExpensesource_id">
                <option value="">Unknown</option>
                <?php while ($rowExpensesource = mysqli_fetch_array($expensesource)) {
                    echo "<option value='{$rowExpensesource["id"]}'>{$rowExpensesource["expensesource_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 4" id="dataAddAdvanced">
            <label for="txtVolume"><p>Volume</p></label>
            <input type="number" name="txtVolume" id="txtVolume" step="any" />
        </div>
        <div class="dataDetails" style="grid-column: 4 / 5" id="dataAddAdvanced">
            <label for=""><p>Type</p><img onclick="registerVolumeType(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtExpensevolumeTypes_id" id="txtExpensevolumeTypes_id">
                <option value="">Unknown</option>
                <?php while ($rowExpenvolumeTypes = mysqli_fetch_array($expensevolumeTypes)) {
                    echo "<option value='{$rowExpenvolumeTypes["id"]}'>{$rowExpenvolumeTypes["volumeType_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 5">
            <label for=""><p>Store</p><img onclick="registerStore(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtStore_id" id="txtStore_id">
                <option value="">Unknown</option>
                <?php while ($rowStore = mysqli_fetch_array($store)) {
                    echo "<option value='{$rowStore["id"]}'>{$rowStore["store_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 3">
            <label for=""><p>Year</p><img onclick="registerYear(), registerExpense()" src="/img/pluss.png" alt=""></label>
            <select name="txtYear_id[]" id="txtYear_id" multiple required>
                <?php while ($rowYear = mysqli_fetch_array($year)) {
                    echo "<option value='{$rowYear["id"]}'>{$rowYear["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 3 / 5">
            <label for=""><p>Month</p></label>
            <select name="txtMonth_id[]" id="txtMonth_id" multiple required>
                <?php while ($rowMonth = mysqli_fetch_array($month)) {
                    echo "<option value='{$rowMonth["id"]}'>{$rowMonth["month_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 1 / 3">
            <label for=""><p>Date</p></label>
            <select name="txtDate_id" id="txtDate_id">
                <option value="">Unknown</option>
                <?php while ($rowDate = mysqli_fetch_array($date)) {
                    echo "<option value='{$rowDate["id"]}'>{$rowDate["id"]}</option>";
                }
                ?>
            </select>
        </div>
        <div class="dataDetails" style="grid-column: 3 / 5">
            <label for=""><p>Day</p></label>
            <select name="txtDay_id" id="txtDay_id">
                <option value="">Unknown</option>
                <?php while ($rowDay = mysqli_fetch_array($day)) {
                    echo "<option value='{$rowDay["id"]}'>{$rowDay["day_name"]}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit" style="grid-column: 1 / 5">Submit</button>
    </form>
</div>

<!-- expense category -->
<div class="floatingForm" id="registerExpenseCategory">
    <form action="/prosess/expenseCategory.php" method="post" class="data">
        <header>
            <h2>add expense category</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpenseCategory()">
        </header>
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
        <header>
            <h2>add expense source</h2>
            <img src="/img/pluss.png" alt="" onclick="registerExpenseSource()">
        </header>
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
        <header>
            <h2>Add Store</h2>
            <img src="/img/pluss.png" alt="" onclick="registerStore()">
        </header>
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
        <header>
            <h2>add year</h2>
            <img src="/img/pluss.png" alt="" onclick="registerYear()">
        </header>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="years"><p>Year</p></label>
            <input type="number" id="years" name="years">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- volume type -->
<div class="floatingForm" id="registerVolumeType">
    <form action="/prosess/registerVolumeType.php" method="post" class="data">
        <header>
            <h2>Add Volume Type</h2>
            <img src="/img/pluss.png" alt="" onclick="registerVolumeType()">
        </header>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="volumeType"><p>Volume Type</p></label>
            <input type="text" name="volumeType_name">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- Income category -->
<div class="floatingForm" id="registerIncomeCategory">
    <form action="/prosess/incomeCategory.php" method="post" class="data">
        <header>
            <h2>add income category</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncomeCategory()">
        </header>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="category"><p>Category</p></label>
            <input type="text" name="incomecategory_name">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- incomesource -->
<div class="floatingForm" id="registerIncomeSource">
    <form action="/prosess/incomeSource.php" method="post" class="data">
        <header>
            <h2>add income source</h2>
            <img src="/img/pluss.png" alt="" onclick="registerIncomeSource()">
        </header>
        <div class="dataDetails" style="grid-column: 1 / 3;">
            <label for="incomesource"><p>Source</p></label>
            <input type="text" id="incomesource" name="incomesource">
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
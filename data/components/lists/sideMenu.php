<div class="sidemenu">
    <p class="sidemenudevider">Expense</p>
    <a href="/lists/expense" ><div <?php echo strpos($current_page, '/lists/expense') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Expenses</div></a>
    <a href="/lists/expense/category.php"><div <?php echo strpos($current_page, '/lists/expense/category') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Categories</div></a>
    <a href="/lists/expense/source.php"><div <?php echo strpos($current_page, '/lists/expense/source.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Source</div></a>
    <p class="sidemenudevider">Income</p>
    <a href="/lists/income"><div <?php echo strpos($current_page, '/lists/income') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Income</div></a>
    <a href="/lists/income/category.php"><div <?php echo strpos($current_page, '/lists/income/category.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Categories</div></a>
    <a href="/lists/income/source.php"><div <?php echo strpos($current_page, '/lists/income/source.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Sources</div></a>
    <p class="sidemenudevider">Other</p>
    <a href="/lists/other/store.php"><div <?php echo strpos($current_page, '/lists/other/store.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Stores</div></a>
</div>
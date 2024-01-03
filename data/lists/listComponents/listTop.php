    <?php
    // Get the current page URL
    $current_page = $_SERVER['REQUEST_URI'];
    ?>

    <?php require '../components/head.php'; ?>
    <body>

    <main>
        <?php require '../components/nav.php'; ?>
        <section class="home">
            <h1>Lists</h1>
            <section class="listContent">
                <section class="listNavigation">
                    <div class="listSources">
                        <a href="/lists/expense.php" <?php echo strpos($current_page, '/lists/expense.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Expenses</div></a>
                        <a href="/lists/expenseCategory.php" <?php echo strpos($current_page, '/lists/expenseCategory.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Expenses Categories</div></a>
                        <a href="/lists/expenseSource.php" <?php echo strpos($current_page, '/lists/expenseSource.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Expense Source</div></a>
                        <a href="/lists/income.php" <?php echo strpos($current_page, '/lists/income.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Income</div></a>
                        <a href="/lists/incomeCategory.php" <?php echo strpos($current_page, '/lists/incomeCategory.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Income Categories</div></a>
                        <a href="/lists/incomeSource.php" <?php echo strpos($current_page, '/lists/incomeSource.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Income Sources</div></a>
                        <a href="/lists/volumeTypes.php" <?php echo strpos($current_page, '/lists/volumeTypes.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Volume Types</div></a>
                        <a href="/lists/store.php" <?php echo strpos($current_page, '/lists/store.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Stores</div></a>
                        <a href="/lists/years.php" <?php echo strpos($current_page, '/lists/years.php') !== false ? 'class="listsSelected"' : ''; ?>><div>Years</div></a>
                    </div>
                    <div class="listSearch">
                        <input type="text" placeholder="search" id="searchInput">
                    </div>
                </section>
                <div class="listTable" id="listTableContainer">
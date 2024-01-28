    <?php
    // Get the current page URL
    $current_page = $_SERVER['REQUEST_URI'];
    ?>

    <?php require '../components/head.php'; ?>
    <body>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="sort.js"></script>

    <main>
        <?php require '../nav/nav.php'; ?>
        <section class="list">
            <div class="sidemenu">
                <p class="sidemenudevider">Expense</p>
                <a href="/lists/expense.php" ><div <?php echo strpos($current_page, '/lists/expense.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Expenses</div></a>
                <a href="/lists/expenseCategory.php"><div <?php echo strpos($current_page, '/lists/expenseCategory.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Categories</div></a>
                <a href="/lists/expenseSource.php"><div <?php echo strpos($current_page, '/lists/expenseSource.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Source</div></a>
                <p class="sidemenudevider">Income</p>
                <a href="/lists/income.php"><div <?php echo strpos($current_page, '/lists/income.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Income</div></a>
                <a href="/lists/incomeCategory.php"><div <?php echo strpos($current_page, '/lists/incomeCategory.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Categories</div></a>
                <a href="/lists/incomeSource.php"><div <?php echo strpos($current_page, '/lists/incomeSource.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Sources</div></a>
                <p class="sidemenudevider">Other</p>
                <a href="/lists/volumeTypes.php"><div <?php echo strpos($current_page, '/lists/volumeTypes.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Volume Types</div></a>
                <a href="/lists/store.php"><div <?php echo strpos($current_page, '/lists/store.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Stores</div></a>
                <a href="/lists/years.php"><div <?php echo strpos($current_page, '/lists/years.php') !== false ? 'class="sidemenuItemSelected"' : ''; ?>>Years</div></a>
            </div>
            <section class="listContent">
                <section class="listNavigation">
                    <div class="listNavigationDeff">
                        <button> <img src="/img/pluss.png" alt="">New</button>
                        <div class="listSearch">
                            <input type="text" placeholder="search" id="searchInput">
                        </div>
                        <button> <img src="/img/sort.png" alt=""></button>
                        <button> <img src="/img/gear.png" alt=""></button>
                    </div>
                    <div class="listNavigationOnSelect">
                        <button id="deleteSelectedButton"> <img src="/img/bin.png" alt="">Delete</button>
                        <button id="editSelectedButton"><img src="/img/pen.png" alt="">Edit</button>
                    </div>
                </section>
                <div class="listTable" id="listTableContainer">
                <table>

<?php
require '../components/head.php';
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
                <a href="/lists/income.php"><div>Income</div></a>
                <a href="/lists/incomeCategory.php"><div>Income Categories</div></a>
                <a href="/lists/incomeSource.php"><div>Income Sources</div></a>
                <a href=""><div>Expenses</div></a>
                <a href=""><div>Expenses Categories</div></a>
                <a href=""><div>Expense Product</div></a>
            </div>
            <div class="listSearch">
                <input type="text" placeholder="search" id="searchInput">
            </div>
            <div class="listTable" id="listTableContainer">
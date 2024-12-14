<?php

// Get the current page URL
$current_page = $_SERVER['REQUEST_URI']; 
require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php'; 

?>

    <body>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="sort.js"></script>

    <main>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/components/nav.php'; ?>
        <section class="list">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/components/lists/sideMenu.php'; ?>
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
                        <button style="margin-right: 10px;" id="deleteSelectedButton"> <img src="/img/bin.png" alt="">Delete</button>
                        <button id="editSelectedButton"><img src="/img/pen.png" alt="">Edit</button>
                    </div>
                </section>
                <div class="listTable" id="listTableContainer">
                <table>

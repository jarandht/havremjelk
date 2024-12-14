<?php
// Get the current page from the request URI
$current_page = $_SERVER['REQUEST_URI'];
?>

<nav class="navSide">
    <div class="navLogo">
        <img src="/img/oatmeal.png" alt="">
    </div>
    <a href="/forms" <?php echo strpos($current_page, '/forms') !== false ? 'class="navSiteSelected"' : ''; ?>>
        <div class="navRegister" onclick="registerIncome()">
            <img src="/img/pluss.png" alt="">
        </div>
    </a>
    <div class="navDevider"></div>
    <a href="/home" <?php echo strpos($current_page, '/home') !== false ? 'class="navSiteSelected"' : ''; ?>>
        <div>
            <img src="/img/home.png" alt="">
        </div>
    </a>
    <a href="/table" <?php echo strpos($current_page, '/table') !== false ? 'class="navSiteSelected"' : ''; ?>>
        <div>
            <img src="/img/table.png" alt="">
        </div>
    </a>
    <a href="/lists" <?php echo strpos($current_page, '/lists') !== false ? 'class="navSiteSelected"' : ''; ?>>
        <div>
            <img src="/img/list.png" alt="">
        </div>
    </a>
    <a href="/settings" <?php echo strpos($current_page, '/settings') !== false ? 'class="navSiteSelected"' : ''; ?>>
        <div>
            <img src="/img/gear.png" alt="">
        </div>
    </a>
</nav>
<nav class="navTop">
    <?php
    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $url_parts = explode('/', trim($url_path, '/'));
    $first_segment = isset($url_parts[0]) ? $url_parts[0] : '';
    ?>
    <h1><?php echo $first_segment; ?></h1>
    <a href="">
        <img src="/img/question.png" alt="">
    </a>
</nav>
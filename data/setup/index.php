<?php
require '../components/db.php';
echo "<h2>Database setup complete, redirecting.</h2>"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup</title>
    <script>
        setTimeout(function() {
            window.location.href = "/";
        }, 21000); // 5000 milliseconds = 5 seconds
    </script>
</head>
</html>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
    html{
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        font-family: quicksand;
    }
    p::after{
        margin-top: 20px;
        content: '';
        display: block;
        height: 2px; 
        width: 100%;
        background: black;
    }
    p:last-child::after{
        content: none;
    }
</style>
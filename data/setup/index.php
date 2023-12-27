<?php
require '../components/db.php';
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
        }, 1000000); // 5000 milliseconds = 5 seconds
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
    ::after{
        content: 'asdasd';
        display: block;
        height: 100px; 
        width: 100px;
        background: red;
    }
</style>
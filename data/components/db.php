<?php
require 'head.php';

require 'creds.php';


try {
    // Create a connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to create the 'category' table
    $createIncomecategoryTableSQL = "CREATE TABLE IF NOT EXISTS incomecategory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        incomecategory_name VARCHAR(255)
    )";

    // Execute the query
    if ($conn->exec($createIncomecategoryTableSQL) !== false) {
        echo "Table 'incomecategory' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'incomecategory' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // SQL query to create the 'incomesource' table
    $createIncomeSourceTableSQL = "CREATE TABLE IF NOT EXISTS incomesource (
        id INT AUTO_INCREMENT PRIMARY KEY,
        incomesource_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createIncomeSourceTableSQL) !== false) {
        echo "Table 'incomesource' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'incomesource' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // SQL query to create the 'days' table
    $createDaysTableSQL = "CREATE TABLE IF NOT EXISTS days (
        id INT PRIMARY KEY,
        day_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createDaysTableSQL) !== false) {
        echo "Table 'days' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'days' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // Insert days data if the 'days' table is created
    if ($conn->query("SELECT COUNT(*) FROM days")->fetchColumn() == 0) {
        $insertDaysDataSQL = "INSERT INTO days (id, day_name) VALUES
            (1, 'Monday'),
            (2, 'Tuesday'),
            (3, 'Wednesday'),
            (4, 'Thursday'),
            (5, 'Friday'),
            (6, 'Saturday'),
            (7, 'Sunday')";

        if ($conn->exec($insertDaysDataSQL) !== false) {
            echo "Days data inserted successfully<br>";
        } else {
            $errorInfo = $conn->errorInfo();
            echo "Error inserting days data: " . implode(", ", $errorInfo) . "<br>";
        }
    }

    // SQL query to create the 'months' table
    $createMonthsTableSQL = "CREATE TABLE IF NOT EXISTS months (
        id INT PRIMARY KEY,
        month_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createMonthsTableSQL) !== false) {
        echo "Table 'months' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'months' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // Insert months data if the 'months' table is created
    if ($conn->query("SELECT COUNT(*) FROM months")->fetchColumn() == 0) {
        $insertMonthsDataSQL = "INSERT INTO months (id, month_name) VALUES
            (1, 'January'),
            (2, 'February'),
            (3, 'March'),
            (4, 'April'),
            (5, 'May'),
            (6, 'June'),
            (7, 'July'),
            (8, 'August'),
            (9, 'September'),
            (10, 'October'),
            (11, 'November'),
            (12, 'December')";

        if ($conn->exec($insertMonthsDataSQL) !== false) {
            echo "Months data inserted successfully<br>";
        } else {
            $errorInfo = $conn->errorInfo();
            echo "Error inserting months data: " . implode(", ", $errorInfo) . "<br>";
        }
    }

    // SQL query to create the 'dates' table
    $createDatesTableSQL = "CREATE TABLE IF NOT EXISTS dates (
        id INT PRIMARY KEY
    )";

    // Execute the query
    if ($conn->exec($createDatesTableSQL) !== false) {
        echo "Table 'dates' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'dates' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // Insert dates data if the 'dates' table is created
    if ($conn->query("SELECT COUNT(*) FROM dates")->fetchColumn() == 0) {
        $insertDatesDataSQL = "INSERT INTO dates (id) VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20),(21),(22),(23),(24),(25),(26),(27),(28),(29),(30),(31)";

        if ($conn->exec($insertDatesDataSQL) !== false) {
            echo "Dates data inserted successfully<br>";
        } else {
            $errorInfo = $conn->errorInfo();
            echo "Error inserting dates data: " . implode(", ", $errorInfo) . "<br>";
        }
    }

    // SQL query to create the 'years' table
    $createYearsTableSQL = "CREATE TABLE IF NOT EXISTS years (
        id INT PRIMARY KEY
    )";

    // Execute the query
    if ($conn->exec($createYearsTableSQL) !== false) {
        echo "Table 'years' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'years' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // Insert years data if the 'years' table is created
    if ($conn->query("SELECT COUNT(*) FROM years")->fetchColumn() == 0) {
        $insertYearsDataSQL = "INSERT INTO years (id) VALUES (2024)";

        if ($conn->exec($insertYearsDataSQL) !== false) {
            echo "Years data inserted successfully<br>";
        } else {
            $errorInfo = $conn->errorInfo();
            echo "Error inserting years data: " . implode(", ", $errorInfo) . "<br>";
        }
    }


    // SQL query to create the 'income' table with foreign key constraints
    $createIncomeTableSQL = "CREATE TABLE IF NOT EXISTS income (
        income_id INT AUTO_INCREMENT PRIMARY KEY,
        amount VARCHAR(255) NOT NULL,
        day_id INT,
        month_id INT,
        date_id INT,
        year_id INT,
        incomecategory_id INT,
        incomesource_id INT,
        FOREIGN KEY (day_id) REFERENCES days(id),
        FOREIGN KEY (month_id) REFERENCES months(id),
        FOREIGN KEY (date_id) REFERENCES dates(id),
        FOREIGN KEY (year_id) REFERENCES years(id),
        FOREIGN KEY (incomecategory_id) REFERENCES incomecategory(id),
        FOREIGN KEY (incomesource_id) REFERENCES incomesource(id)
    )";

    // Execute the query
    if ($conn->exec($createIncomeTableSQL) !== false) {
        echo "Table 'income' created successfully";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'income' table: " . implode(", ", $errorInfo);
    }

    
    // SQL query to create the 'source' table
    $createExpenseSourceTableSQL = "CREATE TABLE IF NOT EXISTS expensesource (
        id INT AUTO_INCREMENT PRIMARY KEY,
        expensesource_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createExpenseSourceTableSQL) !== false) {
        echo "Table 'expensesource' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'expensesource' table: " . implode(", ", $errorInfo) . "<br>";
    }
    
    // SQL query to create the 'source' table
    $createExpenseCategoryTableSQL = "CREATE TABLE IF NOT EXISTS expensecategory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        expensecategory_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createExpenseCategoryTableSQL) !== false) {
        echo "Table 'expensecategory' created successfully<br>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'expensecategory' table: " . implode(", ", $errorInfo) . "<br>";
    }

    // SQL query to create the 'expense' table with foreign key constraints
    $createExpenseTableSQL = "CREATE TABLE IF NOT EXISTS expense (
        expense_id INT AUTO_INCREMENT PRIMARY KEY,
        chost VARCHAR(255) NOT NULL,
        day_id INT,
        month_id INT,
        date_id INT,
        year_id INT,
        expensesource_id INT,
        expensecategory_id INT,
        FOREIGN KEY (day_id) REFERENCES days(id),
        FOREIGN KEY (month_id) REFERENCES months(id),
        FOREIGN KEY (date_id) REFERENCES dates(id),
        FOREIGN KEY (year_id) REFERENCES years(id),
        FOREIGN KEY (expensesource_id) REFERENCES expensesource(id)
        FOREIGN KEY (expensecategory_id) REFERENCES expensecategory(id)
    )";


    // Execute the query
    if ($conn->exec($createIncomeTableSQL) !== false) {
        echo "Table 'expense' created successfully";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Error creating 'expense' table: " . implode(", ", $errorInfo);
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
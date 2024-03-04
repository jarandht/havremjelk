<?php
require 'creds.php';

$setupSuccess = true;

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
        echo "<p>Table 'incomecategory' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'incomecategory' table: " . implode(", ", $errorInfo) . "</p>";
    }

    // SQL query to create the 'incomesource' table
    $createIncomeSourceTableSQL = "CREATE TABLE IF NOT EXISTS incomesource (
        id INT AUTO_INCREMENT PRIMARY KEY,
        incomesource_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createIncomeSourceTableSQL) !== false) {
        echo "<p>Table 'incomesource' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'incomesource' table: " . implode(", ", $errorInfo) . "</p>";
    }

    // SQL query to create the 'income' table with foreign key constraints
    $createIncomeTableSQL = "CREATE TABLE IF NOT EXISTS income (
        income_id INT AUTO_INCREMENT PRIMARY KEY,
        amount VARCHAR(255) NOT NULL,
        comment VARCHAR(255),
        date DATE NOT NULL,
        incomecategory_id INT,
        incomesource_id INT,
        FOREIGN KEY (incomecategory_id) REFERENCES incomecategory(id),
        FOREIGN KEY (incomesource_id) REFERENCES incomesource(id)
    )";

    // Execute the query
    if ($conn->exec($createIncomeTableSQL) !== false) {
        echo "<p>Table 'income' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'income' table: " . implode(", ", $errorInfo) . "</p>";
    }

    // SQL query to create the 'source' table
    $createExpenseSourceTableSQL = "CREATE TABLE IF NOT EXISTS expensesource (
        id INT AUTO_INCREMENT PRIMARY KEY,
        expensesource_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createExpenseSourceTableSQL) !== false) {
        echo "<p>Table 'expensesource' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'expensesource' table: " . implode(", ", $errorInfo) . "</p>";
    }

    // SQL query to create the 'expensecategory' table
    $createExpenseCategoryTableSQL = "CREATE TABLE IF NOT EXISTS expensecategory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        expensecategory_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createExpenseCategoryTableSQL) !== false) {
        echo "<p>Table 'expensecategory' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'expensecategory' table: " . implode(", ", $errorInfo) . "</p>";
    }
    
    // SQL query to create the 'store' table
    $createStoreTableSQL = "CREATE TABLE IF NOT EXISTS store (
        id INT AUTO_INCREMENT PRIMARY KEY,
        store_name VARCHAR(255) NOT NULL
    )";

    // Execute the query
    if ($conn->exec($createStoreTableSQL) !== false) {
        echo "<p>Table 'store' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'store' table: " . implode(", ", $errorInfo) . "</p>";
    }

    // SQL query to create the 'expense' table with foreign key constraints
    $createExpenseTableSQL = "CREATE TABLE IF NOT EXISTS expense (
        expense_id INT AUTO_INCREMENT PRIMARY KEY,
        chost VARCHAR(255) NOT NULL,
        volume VARCHAR(255),
        discount VARCHAR(255),
        comment VARCHAR(255),
        date DATE NOT NULL,
        expensesource_id INT,
        expensecategory_id INT,
        store_id INT,
        FOREIGN KEY (expensesource_id) REFERENCES expensesource(id),
        FOREIGN KEY (expensecategory_id) REFERENCES expensecategory(id),
        FOREIGN KEY (store_id) REFERENCES store(id)
    )";

    // Execute the query
    if ($conn->exec($createExpenseTableSQL) !== false) {
        echo "<p>Table 'expense' created successfully</p>";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "<p>Error creating 'expense' table: " . implode(", ", $errorInfo) . "</p>";
    }

} catch (PDOException $e) {
    $setupSuccess = false;
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
}

// Close the connection
$conn = null;

// Check if there were no errors during setup
if ($setupSuccess) {
    echo '<h2>Database setup complete, redirecting.</h2><script src="../setup/redirect.js"></script>';
    // Add code for redirection here if needed
} else {
    echo "<p>Some error occurred during database setup.</p>";
}
?>r
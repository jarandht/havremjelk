<?php
// Check the connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

// Get the search term from the request
$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

// Perform a database query for expensecategory_name
$sqlexpensecategory = "SELECT id, expensecategory_name FROM expensecategory WHERE expensecategory_name LIKE '%$searchTerm%'";
$resultExpenseCategory = $conn->query($sqlexpensecategory);

// Perform a database query for expensesource_name
$sqlexpensesource = "SELECT id, expensesource_name FROM expensesource WHERE expensesource_name LIKE '%$searchTerm%'";
$resultExpenseSource = $conn->query($sqlexpensesource);

// Perform a database query for store_name
$sqlstore = "SELECT id, store_name FROM store WHERE store_name LIKE '%$searchTerm%'";
$resultStore = $conn->query($sqlstore);

// Fetch the results
$data = array();
while ($row = $resultExpenseCategory->fetch_assoc()) {
   $data[] = array(
      'id' => $row['id'],
      'text' => $row['expensecategory_name']
   );
}
while ($row = $resultExpenseSource->fetch_assoc()) {
   $data[] = array(
      'id' => $row['id'],
      'text' => $row['expensesource_name']
   );
}
while ($row = $resultStore->fetch_assoc()) {
   $data[] = array(
      'id' => $row['id'],
      'text' => $row['store_name']
   );
}
?>

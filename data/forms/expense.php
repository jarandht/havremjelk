<?php
require '../components/head.php';
require '../components/creds.php';
require 'search.php';

$conn = new mysqli($servername, $username, $password, $database);

$sqlexpensecategory = "SELECT id, expensecategory_name FROM expensecategory";
$expensecategory = $conn->query($sqlexpensecategory);

$sqlexpensesource = "SELECT id, expensesource_name FROM expensesource";
$expensesource = $conn->query($sqlexpensesource);

$sqlexpensevolumeTypes = "SELECT id, volumeType_name FROM volumeTypes";
$expensevolumeTypes = $conn->query($sqlexpensevolumeTypes);

$sqlday = "SELECT id, day_name FROM days";
$day = $conn->query($sqlday);

$sqldate = "SELECT id FROM dates";
$date = $conn->query($sqldate);

$sqlmonth = "SELECT id, month_name FROM months";
$month = $conn->query($sqlmonth);

$sqlstore = "SELECT id, store_name FROM store";
$store = $conn->query($sqlstore);

$sqlyear = "SELECT id, id FROM years ORDER BY id DESC";
$year = $conn->query($sqlyear);

$conn->close();
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-zqkZMVAi+Z5Mdy1PZNEj7go+l4H/v5mQs0vFowUeCuI1lxuyTvvoRNGP89YUeGFLzBSyZl0AtcTqAK/HsoGxww==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<main>
   <?php require '../nav/nav.php'; ?>
   <section class="list">
      <?php require './sideMenu.php'; ?>
      <form method="post" action="prosesses/expense.php">
         <section class="listContent">
            <div class="listNavigation formGeneral formHead">
               <button type="submit" name="submit">Submit</button>
               <button type="button" class="addItem">Add Item</button>
               <input type="date" name="txtDate[]" id="txtDate" required />

               <!-- Category -->
               <select require name="txtExpensecategory_id" id="txtExpensecategory_id" required>
                  <option value="">Select Category</option>
                  <option value="__new__">Enter new category</option>
                  <?php while ($rowExpensecategory = mysqli_fetch_array($expensecategory)) {
                        echo "<option value='{$rowExpensecategory["id"]}'>{$rowExpensecategory["expensecategory_name"]}</option>";
                  } ?>
               </select>
               <input type="text" name="txtExpensecategoryName" id="txtExpensecategoryName" style="display: none;" placeholder="New Category">
               
               <!-- Store -->
               <select name="txtStore_id" id="txtStore_id">
                  <option value="">Unknown</option>
                  <option value="__new__">Enter new store</option>
                  <?php while ($rowStore = mysqli_fetch_array($store)) {
                        echo "<option value='{$rowStore["id"]}'>{$rowStore["store_name"]}</option>";
                  } ?>
               </select>
               <input type="text" name="txtStoreName" id="txtStoreName" style="display: none;" placeholder="New Store">
               

            </div>
            <div class="listTable formTable">
               <table>
                  <tr class="tableTH">
                        <th></th>
                        <th>Chost</th>
                        <th>Source</th>
                        <th>Repeat Count</th>
                        <th>Discount</th>
                        <th>Volume</th>
                        <th>Comment</th>
                  </tr>
                  <tr class="tableTD formTD">
                        <td></td> <!-- Placeholder for remove button, initially empty -->
                        <td>
                           <input type="number" name="txtChost[]" class="chost" step="any" required />
                        </td>
                        <td>
                           <div class="formTD-selectDiv">
                              <select name="txtExpensesource_id" id="txtExpensesource_id">
                                    <option value="">Unknown</option>
                                    <option value="__new__">Enter new source</option>
                                    <?php while ($rowExpensesource = mysqli_fetch_array($expensesource)) {
                                          echo "<option value='{$rowExpensesource["id"]}'>{$rowExpensesource["expensesource_name"]}</option>";
                                       } ?>
                              </select>
                              <input type="text" name="txtExpensesourceName" id="txtExpensesourceName" style="display: none;" placeholder="New Expensesource">
                           </div>
                        </td>
                        <td>
                           <input type="number" name="repeatCount" id="repeatCount" />
                        </td>
                        <td>
                           <input type="text" name="txtDiscount[]" class="discount" step="any" />
                        </td>
                        <td>
                           <input type="text" name="txtVolume[]" class="volume" />
                        </td>
                        <td>
                           <input type="text" name="txtComment[]" class="comment" />
                        </td>
                  </tr>
               </table>
            </div>
         </section>
      </form>
   </section>
</main>
</body>
</html>

<script src="date.js"></script>
<script src=" expenseSelect.js"></script>
<script>
   $(document).ready(function() {
      // Add new item when "Add Item" button is clicked
      $('.addItem').click(function() {
         // Clone the first form item
         var newItem = $('.formTD:first').clone();

         // Clear values of input fields in the new item
         newItem.find('input').val('');

         // Append the "Remove" button to the new item
         newItem.find('td:first').html('<button type="button" class="removeItem">Remove</button>');

         // Append the new item to the table
         $('.formTable table').append(newItem);
      });

      // Remove item when "Remove" button is clicked
      $('.formTable').on('click', '.removeItem', function() {
         // Ensure that at least one item remains
         if ($('.formTable table tr').length > 2) {
            $(this).closest('tr').remove();
         }
      });
   });
</script>
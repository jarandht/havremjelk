<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';
require 'incomeSearch.php';

$sqlincomecategory = "SELECT id, incomecategory_name FROM incomecategory";
$incomecategory = $conn->query($sqlincomecategory);

$sqlincomesource = "SELECT id, incomesource_name FROM incomesource";
$incomesource = $conn->query($sqlincomesource);

$conn->close();
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-zqkZMVAi+Z5Mdy1PZNEj7go+l4H/v5mQs0vFowUeCuI1lxuyTvvoRNGP89YUeGFLzBSyZl0AtcTqAK/HsoGxww==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<main>
   <?php require $_SERVER['DOCUMENT_ROOT'] . '/nav/nav.php' ;?>
   <section class="list">
      <?php require './sideMenu.php'; ?>
      <form method="post" action="prosesses/income.php">
         <section class="listContent">
            <div class="listNavigation formGeneral formHead">
               <button type="submit" name="submit">Submit</button>
               <button type="button" class="addItem">Add Item</button>
               <input type="date" name="txtDate[]" id="txtDate" required />

               <!-- Category -->
               <select require name="txtIncomecategory_id" id="txtIncomecategory_id" required>
                  <option value="">Select Category</option>
                  <option value="__new__">Enter new category</option>
                  <?php while ($rowIncomecategory = mysqli_fetch_array($incomecategory)) {
                        echo "<option value='{$rowIncomecategory["id"]}'>{$rowIncomecategory["incomecategory_name"]}</option>";
                  } ?>
               </select>
               <input type="text" name="txtIncomecategoryName" id="txtIncomecategoryName" style="display: none;" placeholder="New Category">

            </div>
            <div class="listTable formTable">
               <table>
                  <tr class="tableTH">
                     <th></th>
                     <th>Amount</th>
                     <th>Source</th>
                     <th>Repeat Count</th>
                     <th>Comment</th>
                  </tr>
                  <tr class="tableTD formTD">
                    <td></td> <!-- Placeholder for remove button, initially empty -->
                    <td>
                        <input type="number" name="txtChost[]" class="chost" step="any" required />
                    </td>
                    <td>
                        <div class="formTD-selectDiv">
                            <select name="txtIncomesource_id" id="txtIncomesource_id">
                                <option value="">Unknown</option>
                                <option value="__new__">Enter new source</option>
                                <?php while ($rowIncomesource = mysqli_fetch_array($incimesource)) {
                                        echo "<option value='{$rowIncomesource["id"]}'>{$rowIncomesource["incomesource_name"]}</option>";
                                    } ?>
                            </select>
                            <input type="text" name="txtIncomesourceName" id="txtIncomesourceName" style="display: none;" placeholder="New Incomesource">
                        </div>
                    </td>
                    <td>
                        <input type="number" name="repeatCount" id="repeatCount"/>
                    </td>
                    <td>
                        <input type="text" name="txtComment[]" class="comment"/>
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
<script src="incomeSelect.js"></script>
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
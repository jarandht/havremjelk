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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-zqkZMVAi+Z5Mdy1PZNEj7go+l4H/v5mQs0vFowUeCuI1lxuyTvvoRNGP89YUeGFLzBSyZl0AtcTqAK/HsoGxww==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
   $(document).ready(function() {
      $('#txtExpensecategory_id').select2({
         theme: 'my-custom-theme',
         tags: true, // Allow users to create new tags
         tokenSeparators: [',', ' '], // Define separators for multiple tags
      });
      $('#txtExpensesource_id').select2({
         theme: 'my-custom-theme'
      });
      $('#txtStore_id').select2({
         theme: 'my-custom-theme'
      });
   });
</script>
<script>
   $(document).ready(function() {
      $('#txtExpensecategory_id').select2({
         theme: 'my-custom-theme',
         placeholder: 'Select Category',
      });

      // Show/hide the text input based on selection
      $('#txtExpensecategory_id').on('change', function () {
         if ($(this).val() === '__new__') {
            $('#txtExpensecategoryName').show();
         } else {
            $('#txtExpensecategoryName').hide();
         }
      });
   });
</script>
<script>
   $(document).ready(function() {
      // Initialize Select2 for Store and Expensesource
      $('#txtStore_id, #txtExpensesource_id').select2({
         theme: 'my-custom-theme',
      });

      // Show/hide the text input for new Store
      $('#txtStore_id').on('change', function () {
         if ($(this).val() === '__new__') {
            $('#txtStoreName').show();
         } else {
            $('#txtStoreName').hide();
         }
      });

      // Show/hide the text input for new Expensesource
      $('#txtExpensesource_id').on('change', function () {
         if ($(this).val() === '__new__') {
            $('#txtExpensesourceName').show();
         } else {
            $('#txtExpensesourceName').hide();
         }
      });
   });
</script>

<main>
    <?php require '../nav/nav.php'; ?>
    <section class="list">
        <?php require './sideMenu.php'; ?>
        <section>
            <form method="post" action="prosesses/expense.php">
                <section class="formContainer">
                    <div class="formHead">
                        <label for="">General Options</label>
                        <input type="date" name="txtDate" id="txtDate" required>
                        <select name="txtExpensecategory_id" id="txtExpensecategory_id" required>
                            <option value="">Select Category</option>
                            <option value="__new__">Enter new category</option>
                            <?php while ($rowExpensecategory = mysqli_fetch_array($expensecategory)) {
                                echo "<option value='{$rowExpensecategory["id"]}'>{$rowExpensecategory["expensecategory_name"]}</option>";
                            } ?>
                        </select>
                        <input type="text" name="txtExpensecategoryName" id="txtExpensecategoryName" style="display: none;" placeholder="New Category">
                       <!-- Store Dropdown -->
                       <select name="txtStore_id" id="txtStore_id">
                           <option value="">Unknown</option>
                            <option value="__new__">Enter new store</option>
                            <?php while ($rowStore = mysqli_fetch_array($store)) {
                                echo "<option value='{$rowStore["id"]}'>{$rowStore["store_name"]}</option>";
                            } ?>
                        </select>
                        <input type="text" name="txtStoreName" id="txtStoreName" style="display: none;" placeholder="New Store">

                    </div>
                    <div class="formItems">
                        <div class="formItem">
                            <label for="">Source</label>
                            <!-- Expensesource Dropdown -->
                            <select name="txtExpensesource_id" id="txtExpensesource_id">
                                <option value="">Unknown</option>
                                <option value="__new__">Enter new expensesource</option>
                                <?php while ($rowExpensesource = mysqli_fetch_array($expensesource)) {
                                    echo "<option value='{$rowExpensesource["id"]}'>{$rowExpensesource["expensesource_name"]}</option>";
                                } ?>
                            </select>
                            <input type="text" name="txtExpensesourceName" id="txtExpensesourceName" style="display: none;" placeholder="New Expensesource">
                        
                            <label for="txtChost">Cost</label>
                            <input type="number" name="txtChost" id="txtChost" step="any" required />

                            <label for="repeatCount">Repeat Count</label>
                            <input type="number" name="repeatCount" id="repeatCount" />

                            <label for="txtDiscount"><p>Discount</p></label>
                            <input type="text" name="txtDiscount" id="txtDiscount"/>

                            <label for="">Volume</label>
                            <input type="number" name="txtVolume" id="txtVolume" step="any" />

                            <label for="">Comment</label>
                            <input type="number" name="txtComment" id="txtComment" step="any" />
                        </div>
                        <div class="formItemAdd">
                            <img src="/img/pluss.png" alt="">Add Item
                        </div>
                        <button type="submit" name="submit">Submit</button>
                    </div>
                </section>
            </form>
        </section>
    </section>
</main>
</body>
</html>
<script src="date.js"></script>

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
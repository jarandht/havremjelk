$(document).ready(function() {
    $('#txtIncomecategory_id').select2({
       theme: 'my-custom-theme',
       tags: true, // Allow users to create new tags
       tokenSeparators: [',', ' '], // Define separators for multiple tags
    });
    $('#txtIncomesource_id').select2({
       theme: 'my-custom-theme'
    });
    $('#txtStore_id').select2({
       theme: 'my-custom-theme'
    });
 });

 $(document).ready(function() {
    $('#txtIncomecategory_id').select2({
       theme: 'my-custom-theme',
       placeholder: 'Select Category',
    });

    // Show/hide the text input based on selection
    $('#txtIncomecategory_id').on('change', function () {
       if ($(this).val() === '__new__') {
          $('#txtIncomecategoryName').show();
       } else {
          $('#txtIncomecategoryName').hide();
       }
    });
 });

 $(document).ready(function() {
    // Initialize Select2 for Store and Incomesource
    $('#txtStore_id, #txtIncomesource_id').select2({
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

    // Show/hide the text input for new Incomesource
    $('#txtIncomesource_id').on('change', function () {
       if ($(this).val() === '__new__') {
          $('#txtIncomesourceName').show();
       } else {
          $('#txtIncomesourceName').hide();
       }
    });
 });
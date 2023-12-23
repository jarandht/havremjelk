$(document).ready(function () {
    $("#searchInput").on("input", function () {
        var searchText = $(this).val().toLowerCase();

        // Iterate over each row in the table body
        $(".listTable tbody tr").each(function () {
            var rowText = $(this).text().toLowerCase();

            // Show or hide the row based on the search text
            $(this).toggle(rowText.includes(searchText));
        });
    });
});
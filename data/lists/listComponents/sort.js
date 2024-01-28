$(document).ready(function () {
    // ... (existing code)

    $("table").on("click", "th", function () {
        var columnIndex = $(this).index();
        var sortOrder = $(this).hasClass("sorted-asc") ? "desc" : "asc";

        sortTable(columnIndex, sortOrder);

        // Remove sorting classes from all th elements
        $("th").removeClass("sorted-asc sorted-desc");

        // Add the appropriate sorting class to the clicked th element
        $(this).addClass(sortOrder === "asc" ? "sorted-asc" : "sorted-desc");
    });

    function sortTable(columnIndex, sortOrder) {
        var rows = $("tbody tr.tableTD").get();

        rows.sort(function (a, b) {
            var x = $(a).children("td").eq(columnIndex).text().toLowerCase();
            var y = $(b).children("td").eq(columnIndex).text().toLowerCase();

            // Convert strings to numbers if possible
            x = $.isNumeric(x) ? parseFloat(x) : x;
            y = $.isNumeric(y) ? parseFloat(y) : y;

            // Convert day and month strings to their respective IDs
            if (columnIndex === 8) { // Day column
                x = parseInt($(a).children("td").eq(8).attr("data-day-id"));
                y = parseInt($(b).children("td").eq(8).attr("data-day-id"));
            } else if (columnIndex === 10) { // Month column
                x = parseInt($(a).children("td").eq(10).attr("data-month-id"));
                y = parseInt($(b).children("td").eq(10).attr("data-month-id"));
            }

            if (sortOrder === 'asc') {
                return x < y ? -1 : x > y ? 1 : 0;
            } else {
                return x > y ? -1 : x < y ? 1 : 0;
            }
        });

        $.each(rows, function (index, row) {
            $("tbody").append(row);
        });
    }
});
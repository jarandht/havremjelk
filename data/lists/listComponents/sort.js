$(document).ready(function () {
    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;

        // Get the current sort direction from the th attribute
        var sortDirection = $(table).find("th").eq(columnIndex).attr("data-sort") || "asc";

        // Remove the "listSortUp" and "listSortDown" classes from all th elements
        $(table).find("th").removeClass("listSortUp listSortDown");

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                // Compare values based on the sort direction
                if (columnIndex === 6) {
                    var xId = parseInt(x.getAttribute("data-month-id")) || 0;
                    var yId = parseInt(y.getAttribute("data-month-id")) || 0;

                    if (sortDirection === "asc" ? xId > yId : xId < yId) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (sortDirection === "asc" ? x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() : x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }

        // Toggle the sort direction for the next click
        sortDirection = sortDirection === "asc" ? "desc" : "asc";

        // Add the appropriate class to the currently sorted th element
        if (sortDirection === "asc") {
            $(table).find("th").eq(columnIndex).addClass("listSortUp");
        } else {
            $(table).find("th").eq(columnIndex).addClass("listSortDown");
        }

        // Update the data-sort attribute for all th elements
        $(table).find("th").attr("data-sort", "default");
        $(table).find("th").eq(columnIndex).attr("data-sort", sortDirection);
    }

    $("th").click(function () {
        var index = $(this).index();
        sortTable(index);
    });
});

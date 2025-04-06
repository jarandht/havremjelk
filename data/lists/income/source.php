<?php
require $_SERVER['DOCUMENT_ROOT'] .  '/components/creds.php';

// Fetch income source data
$sqlIncomeSourceData = "SELECT id, incomesource_name FROM incomesource";
$incomeSourceData = $conn->query($sqlIncomeSourceData);

// Delete
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteIncomeSource"])) {
    $incomeSourceIds = explode(",", $_GET["deleteIncomeSource"]);
    $incomeSourceIds = array_map('intval', $incomeSourceIds);
    $incomeSourceIds = implode(",", $incomeSourceIds);

    $response = ["success" => true, "message" => ""];

    // Attempt to delete and catch any errors
    if (!$conn->query("DELETE FROM incomesource WHERE id IN ($incomeSourceIds)")) {
        $response["success"] = false;
        $response["message"] = "Failed to delete. Some records may be referenced in other tables.";
    }

    // Return response as JSON
    echo json_encode($response);
    exit();
}
?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/lists/listTop.php'; ?>
<table>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
            <th>Source Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $incomeSourceData->data_seek(0);

        while ($row = $incomeSourceData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-income-source-id="<?php echo $row["id"]; ?>"></span></td>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["incomesource_name"]; ?></td>
                <td><a class="listedit" href="?editIncomeSource=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteIncomeSource=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
$(document).ready(function () {
    $("#deleteSelectedButton").on("click", function () {
        var selectedIncomeSources = $(".delete-checkbox:checked").map(function () {
            return $(this).data("income-source-id");
        }).get();

        if (selectedIncomeSources.length > 0) {
            var confirmation = confirm("Are you sure you want to delete the selected income sources?");
            if (confirmation) {
                // Send AJAX request to perform the delete
                $.ajax({
                    url: window.location.pathname, // Use the current PHP file
                    type: "GET",
                    data: {
                        deleteIncomeSource: selectedIncomeSources.join(","),
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Reload the page if deletion was successful
                            location.reload();
                        } else {
                            // Show an alert if deletion failed
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert("An error occurred while attempting to delete the income sources.");
                    },
                });
            }
        } else {
            alert("Please select at least one income source to delete.");
        }
    });

    $("#selectAllCheckbox").on("change", function () {
        var isChecked = $(this).prop("checked");
        $(".delete-checkbox").prop("checked", isChecked).change();
    });

    $(".delete-checkbox").on("change", function () {
        var anyCheckboxChecked = $(".delete-checkbox:checked").length > 0;

        if (anyCheckboxChecked) {
            $(".listNavigationDeff").css("display", "none");
            $(".listNavigationOnSelect").css("display", "flex");

            var selectedCount = $(".delete-checkbox:checked").length;
            if (selectedCount > 1) {
                $("#editSelectedButton").css("display", "none");
            } else {
                $("#editSelectedButton").css("display", "flex");
            }
        } else {
            $(".listNavigationDeff").css("display", "grid");
            $(".listNavigationOnSelect").css("display", "none");
            $("#editSelectedButton").css("display", "flex");
        }
    });
});
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/components/lists/listBtm.php'; ?>
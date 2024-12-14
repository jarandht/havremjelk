<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/creds.php';

// Fetch incomeCategory data
$sqlIncomeCategoryData = "SELECT id, incomecategory_name FROM incomecategory";
$incomeCategoryData = $conn->query($sqlIncomeCategoryData);

// Delete
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteIncomeCategory"])) {
    $incomeCategoryIds = explode(",", $_GET["deleteIncomeCategory"]);
    $incomeCategoryIds = array_map('intval', $incomeCategoryIds);
    $incomeCategoryIds = implode(",", $incomeCategoryIds);
    $conn->query("DELETE FROM incomecategory WHERE id IN ($incomeCategoryIds)");

    // Redirect back to the referring page
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    header("Location: $referer");
    exit();
} 
?>
<?php require 'listComponents/listTop.php'; ?>
<table>
    <thead>
        <tr class="tableTH">
            <th><span class="checkbox"><input style="background-color: var(--dark30)" type="checkbox" id="selectAllCheckbox"></span></th>
            <th class="listSortUp">#</th>
            <th>Category Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Reset the internal pointer to the beginning of the result set
        $incomeCategoryData->data_seek(0);

        while ($row = $incomeCategoryData->fetch_assoc()) {
        ?>
            <tr class="tableTD">
                <td><span class="checkbox"><input type="checkbox" class="delete-checkbox" data-income-category-id="<?php echo $row["id"]; ?>"></span></td>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["incomecategory_name"]; ?></td>
                <td><a class="listedit" href="?editIncomeCategory=<?php echo $row["id"]; ?>"></a></td>
                <td><a class="listdelete" href="?deleteIncomeCategory=<?php echo $row["id"]; ?>"></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#deleteSelectedButton").on("click", function () {
            var selectedIncomeCategories = $(".delete-checkbox:checked").map(function () {
                return $(this).data("income-category-id");
            }).get();

            if (selectedIncomeCategories.length > 0) {
                var confirmation = confirm("Are you sure you want to delete the selected income categories?");
                if (confirmation) {
                    window.location.href = "?deleteIncomeCategory=" + selectedIncomeCategories.join(",");
                }
            } else {
                alert("Please select at least one income category to delete.");
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
<?php require 'listComponents/listBtm.php'; ?>

<section class="editForm" id="editExpenseForm" style="display: none;">
    <header>Edit Expense
    <button id="closeEditForm">X</button>
    </header>
    <form method="post" action="/components/lists/expenseEditProsess.php">
    <input type="hidden" name="expense_id" />

        <label>Chost:</label>
        <div><input type="number" name="txtChost" step="any" required /></div>

        <label>Source:</label>
        <div>
        <select name="txtExpensesource_id" required>
            <option value="">Select Source</option>
            <?php foreach ($expenseSource as $id => $name): ?>
                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
        </div>

        <label>Discount:</label>
        <div><input type="text" name="txtDiscount" /></div>

        <label>Volume:</label>
        <div><input type="text" name="txtVolume" /></div>

        <label>Comment:</label>
        <div><input type="text" name="txtComment" /></div>

        <label>Date:</label>
        <div><input type="date" name="txtDate" required /></div>

        <label>Store:</label>
        <div>
        <select name="txtStore_id">
            <option value="">Select Store</option>
            <?php foreach ($stores as $id => $name): ?>
                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
        </div>

        <label>Category:</label>
        <div>
        <select name="txtExpensecategory_id" required>
            <option value="">Select Category</option>
            <?php foreach ($expenseCategory as $id => $name): ?>
                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
        </div>

        <div><button type="submit">Update Expense</button></div>
    </form>
</section>

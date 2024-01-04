function registerExpense(event) {
    var element = document.getElementById("expenseForm");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }

    // If it's a form submission, trigger it manually
    if (event) {
        var form = element.querySelector("form.data");
        form.submit();
    }

    // Prevent the default form submission
    return false;
}


function registerExpenseCategory() {
    var element = document.getElementById("registerExpenseCategory");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }
}

function registerExpenseSource() {
    var element = document.getElementById("registerExpenseSource");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }
}

function registerStore() {
    var element = document.getElementById("registerStore");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }
}

function registerYear() {
    var element = document.getElementById("registerYear");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }
}

function registerVolumeType() {
    var element = document.getElementById("registerVolumeType");

    // Toggle between display block and none
    if (element.style.display === "flex") {
        element.style.display = "none";
    } else {
        element.style.display = "flex";
    }
}
function registerIncome() {
    var element = document.getElementById("incomeForm");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }
  function registerIncomeCategory() {
    var element = document.getElementById("registerIncomeCategory");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }
  function registerIncomeSource() {
    var element = document.getElementById("registerIncomeSource");

    // Toggle between display block and none
    if (element.style.display === "flex") {
      element.style.display = "none";
    } else {
      element.style.display = "flex";
    }
  }


function toggleAdvancedFields() {
var checkbox = document.getElementById("dataAddAdvancedSwitch");
var advancedDivs = document.querySelectorAll("#dataAddAdvanced");

if (checkbox.checked) {
    // Add the class 'dataAddAdvanced' to each advancedDiv
    advancedDivs.forEach(function (div) {
        div.classList.add("dataAddAdvanced");
    });
} else {
    // Remove the class 'dataAddAdvanced' from each advancedDiv
    advancedDivs.forEach(function (div) {
        div.classList.remove("dataAddAdvanced");
    });
}
}

// Add an event listener to the checkbox
var checkbox = document.getElementById("dataAddAdvancedSwitch");
checkbox.addEventListener("change", toggleAdvancedFields);

// Call the function on page load to set the initial state
toggleAdvancedFields();

function toggleFixedTaskFields() {
    var checkbox = document.getElementById("dataAddFixedTaskSwitch");
    var selectsToToggle = document.querySelectorAll('#txtMonth_id, #txtYear_id');

    selectsToToggle.forEach(function (select) {
        // Change the 'multiple' attribute based on the checkbox state
        select.multiple = checkbox.checked;
    });
}

// Add an event listener to the checkbox
var fixedTaskSwitch = document.getElementById("dataAddFixedTaskSwitch");
fixedTaskSwitch.addEventListener("change", toggleFixedTaskFields);

// Call the function on page load to set the initial state
toggleFixedTaskFields();

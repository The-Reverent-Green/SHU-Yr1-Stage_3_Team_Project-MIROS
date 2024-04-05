document.addEventListener('DOMContentLoaded', function() {
    loadCategories(); // Initial load of categories

    document.getElementById('categorySelect').addEventListener('change', function() {
        var categoryId = this.value;
        loadItems(categoryId); // Load items based on selected category
    });

    document.getElementById('itemSelect').addEventListener('change', function() {
        var itemId = this.value;
        loadSubItems(itemId); // Load sub-items based on selected item
    });
});

function loadCategories() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                var categories = JSON.parse(xhr.responseText);
                populateDropdown('categorySelect', categories);
            } else {
                console.error('Failed to load categories. Status:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'fetch_data.php?action=getCategories', true);
    xhr.send();
}

function loadItems(categoryId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                var items = JSON.parse(xhr.responseText);
                populateDropdown('itemSelect', items);
            } else {
                console.error('Failed to load items. Status:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'fetch_data.php?action=getItems&categoryId=' + categoryId, true);
    xhr.send();
}

function loadSubItems(itemId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                var subItems = JSON.parse(xhr.responseText);
                populateDropdown('subItemSelect', subItems);
            } else {
                console.error('Failed to load sub-items. Status:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'fetch_data.php?action=getSubItems&itemId=' + itemId, true);
    xhr.send();
}

function populateDropdown(elementId, options) {
    var dropdown = document.getElementById(elementId);
    dropdown.innerHTML = ''; // Clear existing options
    options.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.id;
        optionElement.textContent = option.name;
        dropdown.appendChild(optionElement);
    });
}

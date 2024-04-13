document.getElementById('searchBar').addEventListener('input', function () {
    const searchTerm = this.value;
    const selectElement = document.getElementById('usernameSelect');

    if (searchTerm.length >= 3) {
        fetch(`../database/getUsernames.php?searchTerm=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(response => response.json())
        .then(usernames => {
            selectElement.innerHTML = ''; 
            if (usernames.length > 0) {
                usernames.forEach(username => {
                    const option = document.createElement('option');
                    option.value = username;
                    option.textContent = username;
                    selectElement.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.textContent = 'No usernames found';
                option.disabled = true;
                selectElement.appendChild(option);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        selectElement.innerHTML = '';
    }
});
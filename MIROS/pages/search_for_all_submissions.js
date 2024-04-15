document.getElementById('searchBar').addEventListener('input', function () {
    const searchTerm = this.value;
    const selectElement = document.getElementById('submissions-tbody');

    if (searchTerm.length >= 3) {
        fetch(`../database/management_dashboard.php?searchTerm=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(response => response.json())
        .then(submissions => {
            // Clear the existing table rows
            selectElement.innerHTML = '';

            // Check if the submissions array is empty
            if (submissions.length === 0) {
                selectElement.innerHTML = '<tr><td colspan="4">No data available.</td></tr>';
            } else {
                // Generate HTML for each submission
                submissions.forEach(submission => {
                    const row = `<tr>
                    <td>${submission.Date_Of_Submission}</td>
                    <td>${submission.Description}</td>
                    <td>${submission.Verified}</td>
                    <td>${submission.Evidence_attachment}</td>
                                </tr>`;
                    selectElement.innerHTML += row;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectElement.innerHTML = '<tr><td colspan="4">Error loading data.</td></tr>';
        });
    } else {
        selectElement.innerHTML = '';
    }
});
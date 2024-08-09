document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('loginForm');
    const submissionsDiv = document.getElementById('submissions');
    const submissionsBody = document.getElementById('submissionsBody');
    const pageNumberSpan = document.getElementById('pageNumber');
    let currentPage = 1;
    const rowsPerPage = 25;

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(loginForm);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loginForm.classList.add('hidden');
                submissionsDiv.classList.remove('hidden');
                loadSubmissions(currentPage);
            } else {
                alert('Invalid username or password');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function loadSubmissions(page) {
        fetch(`get_submissions.php?page=${page}&limit=${rowsPerPage}`)
            .then(response => response.json())
            .then(data => {
                submissionsBody.innerHTML = '';
                data.submissions.forEach(submission => {
                    const row = document.createElement('tr');
                    for (const key in submission) {
                        const cell = document.createElement('td');
                        cell.textContent = submission[key];
                        row.appendChild(cell);
                    }
                    submissionsBody.appendChild(row);
                });
                pageNumberSpan.textContent = `Page ${page}`;
                document.getElementById('prevPage').disabled = page === 1;
                document.getElementById('nextPage').disabled = !data.hasMore;
            })
            .catch(error => console.error('Error:', error));
    }

    window.changePage = function(delta) {
        currentPage += delta;
        loadSubmissions(currentPage);
    }
});

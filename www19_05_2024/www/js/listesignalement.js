document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const resultContainer = document.getElementById('resultContainer');
    const reportContainer = document.getElementById('reportContainer');
    const userName = document.getElementById('userName');
    const userId = document.getElementById('userId');
    const reportForm = document.getElementById('reportForm');
    const reason = document.getElementById('reason');

    searchForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const search = searchInput.value.trim();
        if (search) {
            const response = await fetch(`search.php?search=${encodeURIComponent(search)}`);
            const users = await response.json();
            resultContainer.innerHTML = '';
            if (users.length > 0) {
                users.forEach(user => {
                    const userDiv = document.createElement('div');
                    userDiv.className = 'user';
                    userDiv.textContent = `${user.prenom} ${user.nom}`;
                    userDiv.addEventListener('click', () => {
                        userName.textContent = `${user.prenom} ${user.nom}`;
                        userId.value = user.id;
                        resultContainer.innerHTML = '';
                        reportContainer.style.display = 'block';
                    });
                    resultContainer.appendChild(userDiv);
                });
            } else {
                resultContainer.textContent = 'Aucun utilisateur trouvé.';
            }
        }
    });

    reportForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = userId.value;
        const reasonText = reason.value.trim();
        if (id && reasonText) {
            const response = await fetch('report.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userId: id, reason: reasonText })
            });
            const result = await response.json();
            if (result.success) {
                alert('Signalement envoyé avec succès.');
                reportContainer.style.display = 'none';
                reason.value = '';
            } else {
                alert('Erreur lors de l\'envoi du signalement.');
            }
        }
    });
});

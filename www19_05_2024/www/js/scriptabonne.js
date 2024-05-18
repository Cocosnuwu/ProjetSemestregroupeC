document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('site-search');
  const searchResults = document.getElementById('search-results');

  searchInput.addEventListener('input', function () {
    const query = this.value.trim();
    if (query.length > 0) {
      fetch(`recherche.php?q=${query}`)
        .then(response => response.json())
        .then(data => {
          let resultsHtml = '';
          if (data.length > 0) {
            data.forEach(prof => {
              resultsHtml += `<p><a href="profile.php?user_id=${prof.id}">${prof.nom}</a></p>`;
            });
            searchResults.style.display = 'block'; // Afficher les résultats
          } else {
            resultsHtml = '<p>Aucun résultat trouvé</p>';
            searchResults.style.display = 'block'; // Afficher "Aucun résultat trouvé"
          }
          searchResults.innerHTML = resultsHtml;
        })
        .catch(error => {
          console.error('Erreur:', error);
          searchResults.style.display = 'none'; // Cacher les résultats en cas d'erreur
        });
    } else {
      searchResults.innerHTML = '';
      searchResults.style.display = 'none'; // Cacher les résultats si la recherche est vide
    }
  });

  // Cacher les résultats de recherche si on clique en dehors de la barre de recherche
  document.addEventListener('click', function (event) {
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
      searchResults.style.display = 'none';
    }
  });
});

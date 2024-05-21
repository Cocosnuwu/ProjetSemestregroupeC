document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('site-search');
  const activityFilter = document.getElementById('activity-filter');
  const languageFilter = document.getElementById('language-filter');
  const searchResults = document.getElementById('search-results');

  function updateSearchResults() {
    const query = searchInput.value.trim();
    const activityValue = activityFilter.value;
    const languageValue = languageFilter.value;

    fetch(`search.php?search=${encodeURIComponent(query)}&activity=${encodeURIComponent(activityValue)}&language=${encodeURIComponent(languageValue)}`)
      .then(response => response.json())
      .then(data => {
        let resultsHtml = '';
        if (data.length > 0) {
          data.forEach(prof => {
            resultsHtml += `<p><a href="voir.php?user_id=${prof.id}">${prof.nom} ${prof.prenom}</a></p>`;
          });
          searchResults.style.display = 'block'; // Afficher les résultats
        } else {
          resultsHtml = '<p class="no-result">Aucun résultat trouvé</p>';
          searchResults.style.display = 'block'; // Afficher "Aucun résultat trouvé"
        }
        searchResults.innerHTML = resultsHtml;
      })
      .catch(error => {
        console.error('Erreur:', error);
        searchResults.style.display = 'none'; // Cacher les résultats en cas d'erreur
      });
  }

  // Écouter les changements dans les filtres et mettre à jour les résultats
  activityFilter.addEventListener('change', updateSearchResults);
  languageFilter.addEventListener('change', updateSearchResults);

  searchInput.addEventListener('input', updateSearchResults);

  // Cacher les résultats de recherche si on clique en dehors de la barre de recherche
  document.addEventListener('click', function (event) {
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
      searchResults.style.display = 'none';
    }
  });
});

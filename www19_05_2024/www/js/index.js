// Code JavaScript pour la recherche en temps réel
    const searchInput = document.getElementById('site-search');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.trim();

      if (searchTerm === '') {
        searchResults.innerHTML = '';
        return;
      }

      fetch('../search.php?search=' + searchTerm)
        .then(response => response.json())
        .then(data => {
          let html = '';

          if (data.length > 0) {
            data.forEach(user => {
              html += `<p><a href="voir.php?id=${user.id}">${user.prenom} ${user.nom}</a></p>`;
            });
          } else {
            html = '<p>Aucun résultat trouvé</p>';
          }

          searchResults.innerHTML = html;
        })
        .catch(error => {
          console.error('Error fetching search results:', error);
        });
    });
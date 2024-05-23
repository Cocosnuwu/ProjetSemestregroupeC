<?php
session_start();
include '../include/database.php';

// Bloquer un contact dans la messagerie
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_user_id = $_SESSION['user']['id'];
    $contact_id = $_POST['user_id'];

    // Mettre à jour le champ blocage à 1
    $query = $db->prepare("UPDATE messagerie SET blocage = 1 WHERE (id1 = :current_user_id AND id2 = :contact_id) OR (id1 = :contact_id AND id2 = :current_user_id)");
    $query->execute(array(':current_user_id' => $current_user_id, ':contact_id' => $contact_id));

    echo "Conversation bloquée avec succès.";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bloquer un utilisateur - RencontreProfs</title>
    <link rel="stylesheet" href="../css/block.css">
    <link rel="stylesheet" href="../css/retour.css">
</head>
<body>
    <h1>Bloquer un utilisateur</h1>
    <form method="POST" action="">
        <label for="user_search">Rechercher un utilisateur :</label>
        <input type="text" id="user_search" name="user_search" placeholder="Nom d'utilisateur" required>
        <input type="hidden" id="user_id" name="user_id">
        <button type="submit">Bloquer</button>
    </form>

    <div id="search_results"></div>
    <div>
  <!-- Bouton de retour -->
  <button class="back-button" onclick="window.location.href = 'acceuilmessagerie.php?user_id=<?php echo $_SESSION['user']['id']; ?>';">
    <i class="fa fa-arrow-left"></i> Retour
  </button>  
</div>
    <script>
        document.getElementById('user_search').addEventListener('input', function() {
            var query = this.value;
            if (query.length > 2) {
                fetch('search_users.php?query=' + query)
                    .then(response => response.json())
                    .then(data => {
                        var results = document.getElementById('search_results');
                        results.innerHTML = '';
                        data.forEach(user => {
                            var div = document.createElement('div');
                            div.textContent = user.Prenom + ' ' + user.Nom;
                            div.dataset.id = user.id;
                            div.addEventListener('click', function() {
                                document.getElementById('user_search').value = this.textContent;
                                document.getElementById('user_id').value = this.dataset.id;
                                results.innerHTML = '';
                            });
                            results.appendChild(div);
                        });
                    });
            }
        });
    </script>
</body>
</html>
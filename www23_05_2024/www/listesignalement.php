<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signalement Utilisateur</title>
    <link rel="stylesheet" href="css/listesignalement.css">
    <link rel="stylesheet" href="css/retour.css">
    <script defer src="js/listesignalement.js"></script>
</head>
<body>
    <div class="container">
    <!-- Bouton de retour -->
    <button class="back-button" onclick="window.location.href = 'menuabonne.php';">
        <i class="fa fa-arrow-left"></i> Retour
    </button>  
        <h1>Signaler un Utilisateur</h1>
        <form id="searchForm">
            <input type="text" id="searchInput" placeholder="Rechercher un utilisateur...">
            <button type="submit">Rechercher</button>
        </form>
        <div id="resultContainer"></div>
        <div id="reportContainer" style="display:none;">
            <h2>Signaler <span id="userName"></span></h2>
            <form id="reportForm">
                <input type="hidden" id="userId">
                <label for="reason">Raison :</label>
                <textarea id="reason" required></textarea>
                <button type="submit">Envoyer le signalement</button>
            </form>
        </div>
    </div>
</body>
</html>

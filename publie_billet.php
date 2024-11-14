<?php

require 'connect.php';
include 'navbar.php';

if (!isset($_SESSION['login'])) {
    echo "Vous devez être connecté pour accéder à cette page. <a href='login.php'>Se connecter</a>";
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    // Utiliser DateTime pour le formatage de la date
    $date_publication = (new DateTime())->format('Y-m-d H:i'); // Format pour la BDD

    // Préparer et exécuter la requête SQL
    $requete = "INSERT INTO billets (titre, contenu, date_publication) VALUES (:titre, :contenu, :date_publication)";
    $requete = $db->prepare($requete);
    $requete->bindParam(':titre', $titre);
    $requete->bindParam(':contenu', $contenu);
    $requete->bindParam(':date_publication', $date_publication);

    if ($requete->execute()) {
        echo "<script>alert('Nouveau billet publié avec succès');
        window.location.href = 'index.php';</script>";
    } else {
        echo "Erreur: " . $requete->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Publier un Billet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Publier un Nouveau Billet</h1>
    <div class="connexion">
        <form method="post" action="" class="form_billet">
            <label for="titre">Titre:</label><br>
            <input type="text" id="titre" name="titre" required><br><br>
            <label for="contenu">Contenu:</label><br>
            <textarea id="contenu" name="contenu" rows="10" cols="30" required></textarea><br><br>
            <input type="submit" value="Publier">
        </form>
    </div>
</body>
</html>

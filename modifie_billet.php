<?php
require 'connect.php';
include 'navbar.php';

// Vérifier si l'identifiant du billet est passé dans l'URL
if (isset($_GET['id_billet'])) {
    $id_billet = $_GET['id_billet'];

    // Récupérer le billet à modifier
    $requete = "SELECT * FROM billets WHERE id_billet = :id_billet";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':id_billet', $id_billet);
    $stmt->execute();
    $billet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le billet existe
    if (!$billet) {
        echo "Billet non trouvé.";
        exit;
    }
} else {
    echo "Aucun identifiant de billet fourni.";
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    // Mettre à jour le billet dans la base de données
    $requete = "UPDATE billets SET titre = :titre, contenu = :contenu WHERE id_billet = :id_billet";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':contenu', $contenu);
    $stmt->bindParam(':id_billet', $id_billet);

    if ($stmt->execute()) {
        echo "<script>alert('Billet modifié avec succès'); window.location.href = 'index.php';</script>";
    } else {
        echo "Erreur lors de la modification du billet.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Billet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="page_modifier">
    <h1>Modifier le Billet</h1>
        <form method="post" action="">
            <label for="titre">Titre:</label><br>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($billet['titre']); ?>" required><br><br>
            <label for="contenu">Contenu:</label><br>
            <textarea id="contenu" name="contenu" rows="10" cols="30" required><?php echo htmlspecialchars($billet['contenu']); ?></textarea><br><br>
            <input type="submit" value="Modifier">
        </form>
    </div>
</body>
</html>

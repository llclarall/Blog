<?php
require 'connect.php';
include 'navbar.php';

if (isset($_GET['id_com']) && isset($_SESSION['login'])) {
    $id_commentaire = $_GET['id_com'];
    $id_user = $_SESSION['login'];
    
    // Récupérer le commentaire s'il appartient à l'utilisateur connecté
    $requete = $db->prepare("SELECT comment FROM commentaires WHERE id_com = ? AND fk_user = ?");
    $requete->execute([$id_commentaire, $id_user]);
    $commentaire = $requete->fetch(PDO::FETCH_ASSOC);

    if ($commentaire) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nouveau_commentaire = $_POST['comment'];
            
            // Mettre à jour le commentaire
            $update = $db->prepare("UPDATE commentaires SET comment = ? WHERE id_com = ?");
            $update->execute([$nouveau_commentaire, $id_commentaire]);
            
            // Afficher une alerte et rediriger
            echo "<script>
                alert('Votre commentaire a été modifié avec succès !');
                window.location.href = 'index.php';
            </script>";
            exit();
        }
    } else {
        echo "Vous n'êtes pas autorisé à modifier ce commentaire.";
        exit();
    }
} else {
    echo "Paramètres invalides.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le commentaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="page_modifier">
        <form method="post">
        <h1>Modifier votre com</h1>
            <label for="comment" class="sr-only">Modifier votre commentaire :</label>
            <textarea id="comment" name="comment" required><?php echo htmlspecialchars($commentaire['comment']); ?></textarea><br><br>
            <input type="submit" value="Modifier">
        </form>
    </div>

</body>
</html>

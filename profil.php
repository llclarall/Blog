<?php 
require 'connect.php';
include 'navbar.php';

// Récupérer le login de l'utilisateur connecté depuis la session
$login = $_SESSION['login'];

// Récupérer les informations de l'utilisateur depuis la base de données
$requete = "SELECT * FROM utilisateurs WHERE id_user = :login";
$stmt = $db->prepare($requete);
$stmt->bindParam(':login', $login);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Si aucun utilisateur n'est trouvé, on affiche un message d'erreur
if (!$utilisateur) {
    echo "Utilisateur non trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
<div class="page_profil">
<h1>Bienvenue sur votre page profil, <?php echo ($utilisateur['prenom']); ?> !</h1>

<p><strong>Nom:</strong> <?php echo ($utilisateur['nom']); ?></p>
<p><strong>Prénom:</strong> <?php echo ($utilisateur['prenom']); ?></p>
<p><strong>Email:</strong> <?php echo ($utilisateur['id_user']); ?></p>

<!-- Afficher la photo de profil si elle existe -->

<?php if (!empty($utilisateur['photo'])): ?>
    <p><strong>Photo de profil :</strong> <img src="<?php echo ($utilisateur['photo']); ?>" alt="Photo de profil"></p>
    <?php else: ?>
        <p><strong>Photo de profil :</strong> <img src="photo/filler.jpg" alt="Photo de profil"></p>
    <?php endif; ?>

<br>

<!-- Bouton pour ajouter ou changer la photo -->
<button onclick="document.getElementById('fileInput').click();">Modifier la photo de profil</button>

<!-- Input caché pour la sélection du fichier -->
<form id="photoForm" action="ajoute_photo.php" method="post" enctype="multipart/form-data" style="display:none;">
    <input type="file" id="fileInput" name="photo" accept="image/jpeg, image/png" onchange="document.getElementById('photoForm').submit();">
</form>
</div>
<br>

</body>
</html>

<?php 
require 'connect.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter/Changer la photo de profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Ajouter ou changer la photo de profil</h1>

    <form action="ajoute_photo.php" method="post" enctype="multipart/form-data">
        <label for="photo">Choisissez une nouvelle photo de profil (JPEG ou PNG, max 2 Mo) :</label><br>
        <input type="file" id="photo" name="photo" accept="image/jpeg, image/png" required><br><br>
        <input type="submit" value="Télécharger la nouvelle photo">
    </form>

    <br>
    <a href="profil.php"><button>Retour au profil</button></a>
</body>
</html>

<?php 
require 'connect.php';
include 'navbar.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    


    <?php
// Exemple lors de la création d'un utilisateur
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Hacher le mot de passe avant de le stocker
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = "INSERT INTO utilisateurs (id_user, prenom, nom, mdp) VALUES (:login, :prenom, :nom :mdp)";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();

    echo "Utilisateur créé avec succès.";
}
?>

<section class="connexion">

<h2>Inscription</h2>

    <form action="traite_inscription.php" method="post" onsubmit="return verifierFormulaire()">

        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="login">Login (mail) :</label>
        <input type="text" id="login" name="login" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirmer mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="S'inscrire">
        <span>tous les champs sont obligatoires</span>
    </form>

</section>

    <script>
        function verifierFormulaire() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php 
require 'connect.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="connexion">
    
    <h2>Connexion</h2>

    <?php
    // Vérifie s'il y a une erreur dans l'URL
    if (isset($_GET['erreur']) && $_GET['erreur'] == 'login') {
        echo "<p style='color:red;'>Identifiant ou mot de passe incorrect.</p>";
    }
    ?>

    <form action="traitelogin.php" method="post">
        <label for="login">Login (mail) :</label>
        <input type="text" id="login" name="login" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
        </div><br>

        <input type="submit" value="Se connecter">
    </form> <br>
    <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>

</section>
<script src="script.js"></script>
</body>
</html>

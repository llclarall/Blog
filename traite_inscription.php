<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
require 'connect.php';

// Vérification des données POST
if (isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $login = $_POST['login'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifier si les mots de passe correspondent
    if ($password === $confirmPassword) {
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $requete = "INSERT INTO utilisateurs (id_user, nom, prenom, mdp) VALUES (:login, :nom, :prenom, :mdp)";
        $stmt = $db->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mdp', $hashedPassword);

        if ($stmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant <a href='login.php'>vous connecter</a>.";
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
} else {
    echo "Tous les champs doivent être remplis.";
}
?>

</body>
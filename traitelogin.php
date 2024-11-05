<?php
require 'connect.php';
$db->query('SET NAMES utf8');

// Vérification des données POST
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password']; 

    // Requête pour vérifier si le login correspond
    $requete = "SELECT * FROM utilisateurs WHERE id_user = :login";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    // Récupérer l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe avec password_verify()
    if ($user && password_verify($password, $user['mdp'])) {
        // Créer une session pour l'utilisateur
        $_SESSION['login'] = $user['id_user'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['role'] = $user['role'];

        // Rediriger vers la page d'accueil ou autre
        header("Location: index.php");
        exit();
    } else {
        // Si le mot de passe est incorrect ou l'utilisateur n'existe pas
        header("Location: login.php?erreur=login");
        exit();
    }
} else {
    // Si le formulaire n'est pas soumis correctement
    header("Location: login.php?erreur=login");
    exit();
}
?>

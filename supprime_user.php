<?php
require 'connect.php';

if (isset($_SESSION['role']) && $_SESSION['role'] === 'proprietaire' && isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    
    // Supprimer l'utilisateur
    $stmt = $db->prepare("DELETE FROM utilisateurs WHERE id_user = :id_user");
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();

    // Supprimer tous les commentaires associés à l'utilisateur
    $stmt = $db->prepare("DELETE FROM commentaires WHERE fk_user = :id_user");
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();

    echo "<script>alert('Utilisateur supprimé avec succès'); window.location.href='affiche_users.php';</script>";
    exit();
} else {
    echo "Accès refusé.";
    exit();
}
?>

<?php
require 'connect.php';

if (isset($_GET['id_com']) && isset($_SESSION['login'])) {
    $id_commentaire = $_GET['id_com'];
    $id_user = $_SESSION['login'];
    
    // Vérifier si l'utilisateur est l'auteur du commentaire
    $requete = $db->prepare("SELECT fk_user FROM commentaires WHERE id_com = ?");
    $requete->execute([$id_commentaire]);
    $commentaire = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($commentaire && $commentaire['fk_user'] == $id_user || $_SESSION['role'] === 'proprietaire') {
        // Supprimer le commentaire
        $delete = $db->prepare("DELETE FROM commentaires WHERE id_com = ?");
        $delete->execute([$id_commentaire]);
        echo "<script>alert('Commentaire supprimé avec succès'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "Vous n'êtes pas autorisé à supprimer ce commentaire.";
    }
} else {
    echo "Paramètres invalides.";
}
?>

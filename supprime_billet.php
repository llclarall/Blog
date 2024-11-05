<?php
require 'connect.php';

// Vérifier si l'identifiant du billet est passé dans l'URL
if (isset($_GET['id_billet'])) {
    $id_billet = $_GET['id_billet'];

    // Supprimer le billet de la base de données
    $requete = "DELETE FROM billets WHERE id_billet = :id_billet";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':id_billet', $id_billet);

    if ($stmt->execute()) {
        echo "<script>alert('Billet supprimé avec succès'); window.location.href = 'index.php';</script>";
    } else {
        echo "Erreur lors de la suppression du billet.";
    }
} else {
    echo "Aucun identifiant de billet fourni.";
}
?>

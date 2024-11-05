<?php 
require 'connect.php';

if (isset($_SESSION['login'])) {
        $id_billet = $_POST['id_billet'];
        $contenu = $_POST['contenu'];
        $fk_user = $_SESSION['login']; // Utilisateur connecté

        // Insertion du commentaire dans la base de données
        $requete = "INSERT INTO commentaires (comment, date_creation, fk_user, fk_billet) 
                    VALUES (:comment, NOW(), :fk_user, :fk_billet)";
        $stmt = $db->prepare($requete);
        $stmt->bindParam(':comment', $contenu);
        $stmt->bindParam(':fk_user', $fk_user);
        $stmt->bindParam(':fk_billet', $id_billet);

        if ($stmt->execute()) {
            echo "Commentaire ajouté avec succès.";
            header("Location: index.php"); // Rediriger après ajout
            exit();
        } else {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    }

?>

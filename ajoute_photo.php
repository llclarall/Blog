<?php
require 'connect.php';

// Récupérer l'utilisateur connecté depuis la session
$login = $_SESSION['login'];

// Récupérer l'ancienne photo de l'utilisateur
$requete = "SELECT photo FROM utilisateurs WHERE id_user = :login";
$stmt = $db->prepare($requete);
$stmt->bindParam(':login', $login);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Définir une image par défaut si aucune photo n'est trouvée
$defaultPhoto = 'uploads/default_profile.jpg'; // Image par défaut
$photoPath = !empty($utilisateur['photo']) ? $utilisateur['photo'] : $defaultPhoto;

// Vérifier si une nouvelle photo a été envoyée
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $photo = $_FILES['photo'];

    // Vérifier la taille et le type du fichier
    if ($photo['size'] <= 2000000 && in_array($photo['type'], ['image/jpeg', 'image/png'])) {

        // Si l'utilisateur a déjà une photo personnalisée, supprimer l'ancienne (pas l'image par défaut)
        if ($photoPath !== $defaultPhoto && file_exists($photoPath)) {
            unlink($photoPath);  // Supprimer l'ancienne photo personnalisée
        }

        // Générer un nom de fichier unique pour éviter les conflits
        $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $newPhotoPath = 'photo/' . uniqid() . '.' . $extension;

        // Déplacer le fichier téléchargé vers le dossier des photos
        if (move_uploaded_file($photo['tmp_name'], $newPhotoPath)) {
            // Mettre à jour le chemin de la photo dans la base de données
            $requete = "UPDATE utilisateurs SET photo = :photo WHERE id_user = :login";
            $stmt = $db->prepare($requete);
            $stmt->bindParam(':photo', $newPhotoPath);
            $stmt->bindParam(':login', $login);
            $stmt->execute();

            echo "Photo de profil mise à jour avec succès.";
        } else {
            echo "Erreur: Le fichier n'a pas pu être déplacé.";
        }
    } else {
        echo "Erreur: Le fichier est trop grand ou n'est pas un type d'image valide.";
    }
} else {
    echo "Erreur lors du téléchargement de la photo. Code erreur: " . $_FILES['photo']['error'];
}

// Rediriger l'utilisateur vers la page de profil après l'upload
header("Location: profil.php");
exit();
?>

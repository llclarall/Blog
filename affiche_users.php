
<?php
require 'connect.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    

<div class="page_profil">
<?php
    // Vérifier si l'utilisateur est un administrateur
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'proprietaire') {
        // Récupérer tous les utilisateurs
        $utilisateurs = $db->query("SELECT * FROM utilisateurs")->fetchAll(PDO::FETCH_ASSOC);
    
        // Afficher la liste des utilisateurs
        echo "<h1>Liste des utilisateurs</h1>";
        foreach ($utilisateurs as $user) {
            echo "<p>{$user['prenom']} {$user['nom']} ({$user['id_user']})";
    
            // Vérifier si l'utilisateur n'est pas le propriétaire pour afficher le bouton de suppression
            if ($user['id_user'] !== $_SESSION['login']) { // Assurez-vous que 'id_user' de session est défini
                echo " <a href='supprime_user.php?id_user={$user['id_user']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'><button>Supprimer</button></a>";
            } else {
                echo " <span>(admin)</span><br><br>"; // Message pour le propriétaire
            }
    
            echo "</p>";
        }
    }

?>
</div>
</body>
</html>

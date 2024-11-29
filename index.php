<?php 
require 'connect.php';
include 'navbar.php';


// Récupérer les 3 derniers billets
$requete = "SELECT * FROM billets ORDER BY date_publication DESC LIMIT 3";
$stmt = $db->query($requete);
$billets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour récupérer les commentaires d'un billet
function getComments($db, $id_billet) {
    $stmt = $db->prepare("SELECT c.id_com, c.comment, c.date_creation, u.id_user, u.photo  
    FROM commentaires c 
    JOIN utilisateurs u ON c.fk_user = u.id_user
    WHERE c.fk_billet = ? 
    ORDER BY c.date_creation DESC");
    $stmt->execute([$id_billet]);
    return $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- le favicon ne marche pas jsp pq -->
    <link rel="icon" href="images/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

</head>

<body>
    <h1>Bienvenue à MMind !</h1>


    <div class="container">
    <?php foreach ($billets as $billet): ?>
        <div class="billet" id="billet-<?php echo $billet['id_billet']; ?>">
            <strong><h2><?php echo ($billet['titre']); ?></h2></strong>
            <span><em>Publié le : <?php echo date('d/m/Y H:i', strtotime($billet['date_publication'])); ?></em></span>
            <p><?php echo nl2br(($billet['contenu'])); ?></p><br>

            <!-- Like container uniquement si l'utilisateur est connecté -->
            <?php if (isset($_SESSION['login'])): ?>
                <div class="like-container">
                    <?php
                    // Vérifie si l'utilisateur a liké ce billet
                    $stmt = $db->prepare("SELECT id_like FROM likes WHERE fk_user = ? AND fk_billet = ?");
                    $stmt->execute([$_SESSION['login'], $billet['id_billet']]);
                    $liked = $stmt->rowCount() > 0; // Si l'utilisateur a liké, liked sera vrai
                    ?>
                    <i id="heart-<?= $billet['id_billet']; ?>" class="heart-icon fa fa-heart <?= $liked ? 'liked' : ''; ?>" onclick="toggleLike(<?= $billet['id_billet']; ?>)"></i>
                    <span id="like-count-<?= $billet['id_billet']; ?>">
                        <?php
                        // Affiche le nombre de likes
                        $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE fk_billet = ?");
                        $stmt->execute([$billet['id_billet']]);
                        $likeCount = $stmt->fetchColumn();
                        echo $likeCount;
                        ?>
                    </span>
                </div>
            <?php endif; ?>


            <!-- Bouton pour afficher ou masquer les commentaires -->
            <?php 
            $commentCount = count(getComments($db, $billet['id_billet'])); 
            ?>
            <button onclick="toggleComments(<?php echo $billet['id_billet']; ?>); this.textContent = this.textContent === 'Masquer les commentaires' ? 'Voir les commentaires (<?php echo $commentCount; ?>)' : 'Masquer les commentaires';">
                Voir les commentaires (<?php echo $commentCount; ?>)
            </button>



            <!-- Afficher les commentaires du billet, masqués par défaut -->    
            <div class="commentaires" id="commentaires-<?php echo $billet['id_billet']; ?>" style="display: none;">
            <h3>Commentaires</h3> <br>
            <?php
            $commentaires = getComments($db, $billet['id_billet']);
            if (count($commentaires) > 0):
                foreach ($commentaires as $commentaire): ?>
                    <div class="commentaire">
                        <p><?php echo nl2br(($commentaire['comment'])); ?></p>
                        <!-- Photo de profil -->
                        <img src="<?php echo (!empty($commentaire['photo']) ? $commentaire['photo'] : 'photo/filler.jpg'); ?>" alt="Photo de profil de <?php echo htmlspecialchars($commentaire['id_user']); ?>" 
                        style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px;      object-fit: cover;">
                        <em><small>Par <?php echo ($commentaire['id_user']); ?>, le <?php echo date('d/m/Y H:i', strtotime($commentaire['date_creation'])); ?></small></em>
                        
                        <div class="container_btn">
                            <?php 
                            // Vérifie si l'utilisateur connecté est admin, propriétaire, ou auteur du commentaire
                            if ((isset($_SESSION['role']) && ($_SESSION['role'] === 'proprietaire')) 
                                || (isset($_SESSION['login']) && $_SESSION['login'] == $commentaire['id_user'])): ?>
                                <!-- Bouton pour modifier le commentaire (visible pour propriétaire) -->
                                <?php if (isset($_SESSION['login']) && $_SESSION['login'] == $commentaire['id_user']): ?>
                                    <a href="modifie_com.php?id_com=<?php echo $commentaire['id_com']; ?>"><button class="modifie">Modifier</button></a>
                                <?php endif; ?>
                                
                                <!-- Bouton pour supprimer le commentaire (visible pour propriétaire) -->
                                <a href="supprime_com.php?id_com=<?php echo $commentaire['id_com']; ?>&id_billet=<?php echo $billet['id_billet']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                    <button class="supprime">Supprimer</button>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <p>Aucun commentaire pour ce billet.</p>
            <?php endif; ?>
        </div>

            

            <!-- Section pour les options de modification/suppression pour le propriétaire -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'proprietaire'): ?>
                <br>
                <a href="modifie_billet.php?id_billet=<?php echo $billet['id_billet']; ?>"><button class="modifie">Modifier</button></a>
                <a href="supprime_billet.php?id_billet=<?php echo $billet['id_billet']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce billet ?');"><button class="supprime">Supprimer</button></a>
            <?php endif; ?>

            <!-- Formulaire pour ajouter un commentaire (visible uniquement si l'utilisateur est connecté) -->
            <?php if (isset($_SESSION['login'])): ?>
                <form method="post" action="ajoute_commentaire.php" id="comment-form">
                    <input type="hidden" name="id_billet" value="<?php echo $billet['id_billet']; ?>">
                
                    <label for="com" class="sr-only">Votre commentaire :</label>
                    <textarea id="com" name="contenu" placeholder="Votre commentaire..." required></textarea><br><br>
                    <button type="submit" class="ajout_com">Ajouter un commentaire</button>
                </form>

                <div id="success-message" style="display: none; color: green;">Commentaire ajouté avec succès !</div>


            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>
<br>

<div class="container_btn">
        <?php if (isset($_SESSION['login'])): ?>
            <a href="archives.php" class="button voirPlus">Voir plus</a><br>
        <?php endif; ?>
        <!-- Formulaire de publication d'un billet pour le propriétaire -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'proprietaire'): ?>
            <br><a href="publie_billet.php" class="button">Publier un billet</a>
        <?php endif; ?>
</div>

<script src="script.js"></script>
</body>
</html>

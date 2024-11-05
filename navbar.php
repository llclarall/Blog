<link rel="stylesheet" href="styles.css">

<?php
// Récupérer le nom de la page actuelle
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <div>
        <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?> logo"><img src="images/clavier.png" alt="accueil"></a>
    </div>
    <div>
        <?php 
        // Afficher "Accueil", "Mon Profil" et "Archives" uniquement si l'utilisateur est connecté
        if (isset($_SESSION['login'])){
            echo '<a href="index.php" class="'. ($current_page == 'index.php' ? 'active' : '') .'">Accueil</a>';
            echo '<a href="profil.php" class="'. ($current_page == 'profil.php' ? 'active' : '') .'">Mon Profil</a>';
            echo '<a href="archives.php" class="'. ($current_page == 'archives.php' ? 'active' : '') .'">Archives</a>';
            
            // Afficher "Utilisateurs" uniquement si l'utilisateur est propriétaire
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'proprietaire') {
                echo '<a href="affiche_users.php">Utilisateurs</a>';
            }
            
            echo '<a href="deconnect.php">Se déconnecter</a>';
        } else {
            // Si l'utilisateur n'est pas connecté, afficher "Se connecter"
            echo '<a href="index.php" class="'. ($current_page == 'index.php' ? 'active' : '') .'">Accueil</a>';
            echo '<a href="inscription.php" class="'. ($current_page == 'inscription.php' ? 'active' : '') .'">S\'inscrire</a>';
            echo '<a href="login.php" class="'. ($current_page == 'login.php' ? 'active' : '') .'">Se connecter</a>';
        }
        ?>
    </div>
</nav>

<?php
require_once 'connect.php';

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['login'])) {
    $userId = $_SESSION['login']; // ID de l'utilisateur connecté
    $billetId = $_POST['billet_id']; // ID du billet

    // Vérifie si l'utilisateur a déjà liké ce billet
    $stmt = $db->prepare("SELECT id_like FROM likes WHERE fk_user = ? AND fk_billet = ?");
    $stmt->execute([$userId, $billetId]);

    // Si l'utilisateur a déjà liké, on le retire
    if ($stmt->rowCount() > 0) {
        // Retire le like
        $stmt = $db->prepare("DELETE FROM likes WHERE fk_user = ? AND fk_billet = ?");
        $stmt->execute([$userId, $billetId]);
        $liked = false;
    } else {
        // Sinon, on ajoute le like
        $stmt = $db->prepare("INSERT INTO likes (fk_user, fk_billet) VALUES (?, ?)");
        $stmt->execute([$userId, $billetId]);
        $liked = true;
    }

    // Récupère le nombre de likes après modification
    $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE fk_billet = ?");
    $stmt->execute([$billetId]);
    $likeCount = $stmt->fetchColumn();

    // Retourne une réponse JSON
    echo json_encode([
        'likes' => $likeCount,
        'liked' => $liked
    ]);
}
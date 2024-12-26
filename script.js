function toggleComments(id_billet) {
    // Récupérer tous les billets et les commentaires
    var billets = document.getElementsByClassName('billet');
    var commentsDiv = document.getElementById('commentaires-' + id_billet);
    var voirPlus = document.querySelector('.voirPlus');

    // Vérifier si la div des commentaires existe
    if (!commentsDiv) {
        console.error("La div des commentaires pour le billet " + id_billet + " n'existe pas.");
        return;
    }

    // Si les commentaires sont déjà visibles, les masquer et réafficher tous les billets
    if (commentsDiv.style.display === 'block') {
        for (var i = 0; i < billets.length; i++) {
            billets[i].style.display = 'block'; 
        }
        commentsDiv.style.display = 'none'; 
        if (voirPlus) voirPlus.style.display = 'block'; 
    } else {
        // Masquer tous les billets sauf celui sélectionné
        for (var i = 0; i < billets.length; i++) {
            if (billets[i].id === 'billet-' + id_billet) {
                billets[i].style.display = 'block'; 
            } else {
                billets[i].style.display = 'none'; 
            }
        }
        commentsDiv.style.display = 'block'; 
        if (voirPlus) voirPlus.style.display = 'none'; 
    }
}



 /* fonction pour liker */
function toggleLike(billetId) {
const heartIcon = document.getElementById(`heart-${billetId}`);
const likeCount = document.getElementById(`like-count-${billetId}`);
// Envoie la requête AJAX pour enregistrer ou supprimer le like
const xhr = new XMLHttpRequest();
xhr.open("POST", "like.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        // Mise à jour du nombre de likes et de l'état du like
        likeCount.textContent = response.likes;
        // Change l'apparence du cœur
        if (response.liked) {
            heartIcon.classList.add('liked'); // Cœur rempli
        } else {
            heartIcon.classList.remove('liked'); // Cœur vide
        }
    }
};
xhr.send(`billet_id=${billetId}`);
}



// Fonction pour afficher ou masquer le mot de passe
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);

    // Vérifie le type actuel de l'input
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleElement.textContent = "🙈"; 
    } else {
        passwordInput.type = "password";
        toggleElement.textContent = "👁️"; 
    }
}
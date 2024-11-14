       // Fonction pour afficher uniquement les commentaires du billet sélectionné et masquer les autres billets
       function toggleComments(id_billet) {
        var billets = document.getElementsByClassName('billet');
        var commentsDiv = document.getElementById('commentaires-' + id_billet);
        var voirPlus = document.querySelector('.voirPlus');

        
        // Si les commentaires sont déjà visibles, les masquer et tout réafficher
        if (commentsDiv.style.display === 'block') {
            for (var i = 0; i < billets.length; i++) {
                billets[i].style.display = 'block'; // Réafficher tous les billets
            }
            commentsDiv.style.display = 'none'; // Masquer les commentaires
        } else {
            // Masquer tous les billets sauf celui sélectionné
            for (var i = 0; i < billets.length; i++) {
                if (billets[i].id === 'billet-' + id_billet) {
                    billets[i].style.display = 'block'; // Afficher le billet sélectionné
                } else {
                    billets[i].style.display = 'none'; // Masquer les autres billets
                }
            }
            commentsDiv.style.display = 'block'; // Afficher les commentaires du billet sélectionné
            voirPlus.style.display = 'none'; // Masquer le bouton "Voir plus"
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


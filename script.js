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

function ajouterBlocAjout() {
    const conteneur = document.getElementById('formulaires-ajout-materiel');
    const bloc = conteneur.querySelector('.bloc-ajout-materiel');
    const nouveauBloc = bloc.cloneNode(true);

    // Vider tous les champs du nouveau bloc
    nouveauBloc.querySelectorAll('input, select, textarea').forEach(input => input.value = '');

    conteneur.appendChild(nouveauBloc);
}

function retirerBlocAjout() {
    const conteneur = document.getElementById('formulaires-ajout-materiel');
    const blocs = conteneur.querySelectorAll('.bloc-ajout-materiel');
    if (blocs.length > 1) {
        conteneur.removeChild(blocs[blocs.length - 1]);
    }
}

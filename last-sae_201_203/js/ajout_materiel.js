function ajouterBloc() {
    const conteneur = document.getElementById('formulaires-materiel');
    const bloc = conteneur.querySelector('.bloc-reservation');
    const nouveauBloc = bloc.cloneNode(true);

    // vider les champs du nouveau bloc
    nouveauBloc.querySelectorAll('input, select, textarea').forEach(input => {
        if (input.type === 'file') {
            input.value = ''; // Réinitialise le champ file
        } else {
            input.value = '';
        }
    });
}

function retirerBloc() {
    const conteneur = document.getElementById('formulaires-materiel');
    const blocs = conteneur.querySelectorAll('.bloc-reservation');

    if (blocs.length > 1) {
        conteneur.removeChild(blocs[blocs.length - 1]);
    }
}


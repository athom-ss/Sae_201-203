function ajouterBloc() {
    const conteneur = document.getElementById('formulaires-materiel');
    const bloc = conteneur.querySelector('.bloc-reservation');
    const nouveauBloc = bloc.cloneNode(true);

    // vider les champs du nouveau bloc
    nouveauBloc.querySelectorAll('input').forEach(input => input.value = '');

    conteneur.appendChild(nouveauBloc);
}

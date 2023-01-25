var cal = {

    //initialiser le calendrier
    hMth:null,      //moi
    hYr:null,       //année
    hWrap:null,     //jours



    init  : () => {

    //obtenir les éléments html by id
    cal.hMth = document.getElementById("calmonth");
    cal.hYr = document.getElementById("calyear");
    cal.hWrap = document.getElementById("calwrap");

    
    //fixer les commandes
    cal.hMth.onchange = cal.draw;
    cal.hYr.onchange = cal.draw;


    //dessiner mois/année en cour
    cal.draw();
    },

//FONCTION DE SOUTIEN - AJAX FETCH
ajax : (data, load) => {
    fetch("ajax.php", { method:"POST", body:data })
    .then(res=>res.text()).then(load);
},
//dessiner calendrier
draw : () => {

    //données de formulaire
    let data = new FormData();
    data.append("req","draw");
    data.append("month",cal.hMth.value);
    data.append("year",cal.hYr.value);

    //AJAX chargé le mois selctioné
    cal.ajax(data, (res) => {

    //fixer le calendrier à son emballage
    cal.hWrap.innerHTML = res;


    });
},



};
/*
quand tout le html et DOM est chargés on excute la fontion init
DOM (document data object) une interface de programmation
qui permet a des scripts de modifier et examiner le contenu d'un navigateur web
*/
window.addEventListener("DOMContentLoaded", cal.init);

/*
.append: ajoute une nouvelle valeur à une clé existante dans un objet FormData
.set: quand la clé exsite elle vas la remplacer alors que append va la rajouter

.ajax: utiliser pour demander des données
data: les données que vont et envoyées au serveur
res: renvoyé la reponse http désirée
*/

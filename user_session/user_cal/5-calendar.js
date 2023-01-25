var cal = {

    //initialiser le calendrier
    hMth:null,      //moi
    hYr:null,       //année
    hWrap:null,     //jours

    //formulaire d'évènement
    hBlock:null, hForm:null, hFormDel:null, hFormCX:null,
    hID:null, hStart:null, hEnd:null, hTxt:null, hColor:null,

    init  : () => {

    //obtenir les éléments html by id
    cal.hMth = document.getElementById("calmonth");
    cal.hYr = document.getElementById("calyear");
    cal.hWrap = document.getElementById("calwrap")
    ;

    cal.hBlock = document.getElementById("calblock");
    cal.hForm = document.getElementById("calform");
    cal.hFormDel = document.getElementById("calformdel");
    cal.hFormCX = document.getElementById("calformcx");

    cal.hID = document.getElementById("evtid");
    cal.httr = document.getElementById("evttitle");
    cal.hlieu = document.getElementById("evtplace");
    cal.hStart = document.getElementById("evtstart");
    cal.hEnd = document.getElementById("evtend");
    cal.hTxt = document.getElementById("evttxt");
    cal.hColor = document.getElementById("evtcolor");
    
    //fixer les commandes
    cal.hMth.onchange = cal.draw;
    cal.hYr.onchange = cal.draw;
    cal.hForm.onsubmit = cal.save;
    cal.hFormDel.onclick = cal.del;
    cal.hFormCX.onclick = cal.hide;

    //dessiner mois/année en cour
    cal.draw();
    },

//FONCTION DE SOUTIEN - AJAX FETCH
ajax : (data, load) => {
    fetch("4-ajax.php", { method:"POST", body:data })
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

    //cliquer sur les cellules des jours pour ajouter des évènement
    for (let day of cal.hWrap.getElementsByClassName("day")) {
        day.onclick = () => { cal.show(day); };
      }

    //cliquer sur un évènement pour l'editer
    for (let evt of cal.hWrap.getElementsByClassName("calevt")) {
        evt.onclick = (e) => { cal.show(evt); e.stopPropagation(); };
      }
    });
},

//montrer le formulaire d'évènements
  show : (cell) => {
    let eid = cell.getAttribute("data-eid");

//ajouter un nouvel évènement
    if (eid === null) {
      let y = cal.hYr.value, m = cal.hMth.value, d = cell.dataset.day;
      if (m.length==1) { m = "0" + m; }
      if (d.length==1) { d = "0" + d; }
      let ymd = `${y}-${m}-${d}T00:00:00`;
      cal.hForm.reset();
      cal.hID.value = "";
      cal.hStart.value = ymd;
      cal.hEnd.value = ymd;
      cal.hFormDel.style.display = "none";
    }    
    
//editer un évènement
    else{
      let edata = JSON.parse(document.getElementById("evt"+eid).innerHTML);
      cal.hID.value = eid;
      cal.hStart.value = edata["evt_start"].replaceAll(" ", "T");
      cal.hEnd.value = edata["evt_end"].replaceAll(" ", "T");
      cal.hTxt.value = edata["evt_text"];
      cal.httr.value = edata["evt_title"];
      cal.hlieu.value = edata["evt_place"];
      cal.hColor.value = edata["evt_color"];
      cal.hFormDel.style.display = "block";
    }

//afficher le formulaire d'évènement
    cal.hBlock.classList.add("show");
},

//masquer le formulaire d'évènement
    hide : () => { cal.hBlock.classList.remove("show"); },

//sauvegarder un évènement
    save : () => {
    cal.ajax(new FormData(cal.hForm), (res) => {
      if (res=="OK") { cal.hide(); cal.draw(); }
      else { alert(res); }
    });
    return false;
  },

//supprimer un évènement
    del : () => { if (confirm("Delete Event?")) {
        
    //données du formulaire
    let data = new FormData();
    data.append("req", "del");
    data.append("eid", cal.hID.value);

    //AJAX supprimer
    cal.ajax(data, (res) => {
      if (res=="OK") { cal.hide(); cal.draw(); }
          else { alert(res); }
    });
  }}
};
 function call() {
    let zvitoZviti = document.getElementById("days_input");
    let dts = new FormData();
    dts.append("req","dis");
    dts.append("number",zvitoZviti.value);
    function ajaxe (data) {
    let map = document.getElementById("fork");

    fetch("4-ajax.php", { method:"POST", body:data }).then(res=> {
            return res.text();     

    }).then(txt => map.innerHTML = txt)
};

    ajaxe(dts);
};
   function dell(id)  { 
    if (confirm("Delete Event?")) {
        
    //données du formulaire
    let data = new FormData();
    data.append("req", "del");
    data.append("eid", id);

   function  showAjax(data, load) {
    fetch("4-ajax.php", { method:"POST", body:data })
    .then(res=>res.text()).then(load);
};

    //AJAX supprimer
    showAjax(data, (res) => {
      if (res=="OK") { called();    }
          else { alert(res); }
    });
  }}
function called() {
    let dts = new FormData();
    dts.append("req","dis");
    dts.append("number",7);
    function ajaxe (data) {
    let map = document.getElementById("fork");

    fetch("4-ajax.php", { method:"POST", body:data }).then(res=> {
            return res.text();     

    }).then(txt => map.innerHTML = txt)
};

    ajaxe(dts);
}

 function disp() {
    document.getElementById("fork1").style.color="block";

}


let a = 0;
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

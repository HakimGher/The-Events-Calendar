//heure été ou hiver
function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();

    // ajouter des 0 pour les nombres < 10
    m = checkTime(m);
    s = checkTime(s);
    t = setTimeout(function() {
      startTime()
    }, 500);

    //heure été ou hiver
    var ete = new Date(2022,02,27,02);
    var hiver = new Date(2022,08,30,03)
    
    if((today > ete) & (today < hiver)){
      document.getElementById('time').innerHTML ="Il est " + h + ":" + m + ":" + s + " (heure d'été)";
    }else{
      document.getElementById('time').innerHTML ="Il est " + h + ":" + m + ":" + s + " (heure d'hiver)";
    }
  }
  startTime();

//Préferences
function showDiv() {
  var x = document.getElementById("Préferences");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

 function changeColorSamedi(){
  var hui = document.styleSheets[0].cssRules;
  var styleBySelector = {};
  for (var i=0; i<hui.length; i++)
  styleBySelector[hui[i].selectorText] = hui[i].style;
  let colorSamedi = document.getElementById('colorSamedi').value;
  styleBySelector[".space.samedi"].backgroundColor = colorSamedi;
 }

 function changeColorDimanche(){
  var hui = document.styleSheets[0].cssRules;
  var styleBySelector = {};
  for (var i=0; i<hui.length; i++)
  styleBySelector[hui[i].selectorText] = hui[i].style;
  let colorDimanche = document.getElementById('colorDimanche').value;
  styleBySelector[".space.dimanche"].backgroundColor = colorDimanche;
 }

 function changeColorFerie(){
  var hui = document.styleSheets[0].cssRules;
  var styleBySelector = {};
  for (var i=0; i<hui.length; i++)
  styleBySelector[hui[i].selectorText] = hui[i].style;
  let colorFerie = document.getElementById('colorFerie').value;
  styleBySelector[".space.ferie"].backgroundColor = colorFerie;
 }
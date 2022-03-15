//Premièrement, on crée des arrays contenant les éléments. Puis on assigne les fonctions aux boutons de manière dynamique pour pas devoir changer la page Twig.

var starRep = document.getElementsByName("student[note_repas]");
var starEnv = document.getElementsByName("note_valeur_environnement");
var starRepLength = starRep.length-1;
var starEnvLength = starEnv.length-1;
for(i=0; i<starRep.length; i++) starRep[i].setAttribute("onclick","onRepClick()");
for(i=0; i<starEnv.length; i++) starEnv[i].setAttribute("onclick","onEnvClick()");
var stars = document.getElementById("polygon1");
var stars = document.getElementById("polygon2");
function onRepClick() {
for(j=0;j<5;j++) stars[j].setAttribute("class","rating__star-off"); //Passe tout en off
for(i=0;i<5;i++) {
    if(starRep[i].checked) {
        for(j=0;j<=i;j++)
        stars[j].setAttribute("class","rating__star-on");
    }
}
}
function onEnvClick() {
for(j=5;j<10;j++) stars[j].setAttribute("class","rating__star-off"); //Passe tout en off
for(i=0;i<5;i++) {
    if(starEnv[i].checked) {
        for(j=5;j<=i+5;j++)
        stars[j].setAttribute("class","rating__star-on");
    }
}
}
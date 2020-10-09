function ani($idFantome){
    if($idFantome === 'fantome1'){
        document.getElementById('fantome1').className ='classGagnant1';
    } else { document.getElementById('fantome1').onclick = '' ;}
    if($idFantome === 'fantome2'){
        document.getElementById('fantome2').className ='classGagnant2';
    } else { document.getElementById('fantome2').onclick = '' ;}
    if($idFantome === 'fantome3'){
        document.getElementById('fantome3').className ='classGagnant3';
    } else { document.getElementById('fantome3').onclick = '' ;}
    if($idFantome === 'fantome4'){
        document.getElementById('fantome4').className ='classGagnant4';
    } else { document.getElementById('fantome4').onclick = '' ;}
    if($idFantome === 'fantome3b'){
        document.getElementById('fantome3b').className ='classGagnant3b';
    } else { document.getElementById('fantome3b').onclick = '' ;}
    if($idFantome === 'fantome4b'){
        document.getElementById('fantome4b').className ='classGagnant4b';
    } else { document.getElementById('fantome4b').onclick = '' ;}
    if($idFantome === 'fantome5'){
        document.getElementById('fantome5').className ='classGagnant5';
    } else { document.getElementById('fantome5').onclick = '' ;}
    if($idFantome === 'fantome6'){
        document.getElementById('fantome6').className ='classGagnant6';
    } else { document.getElementById('fantome6').onclick = '' ;}
    if($idFantome === 'fantome5b'){
        document.getElementById('fantome5b').className ='classGagnant5b';
    } else { document.getElementById('fantome5b').onclick = '' ;}
    if($idFantome === 'fantome6b'){
        document.getElementById('fantome6b').className ='classGagnant6b';
    } else { document.getElementById('fantome6b').onclick = '' ;}
    document.getElementById('phraseFin2').className ='classHide';

    /*    BOUTON DE RETOUR   s'affiche après 10 sec  */
    /*affichage du message de tirage au sort après 10 sec */
    myFunction();
    function myFunction() {
        setInterval(function(){
            document.getElementById('resultatTirage').className = "";
            document.getElementById('divResultat2').className = "bonAchatGagnant2";
            }, 2000);
    }
}


function ani2($idFantome){
    if($idFantome === 'fantome1'){
        document.getElementById('fantome1').className ='classGagnant1';
    } else { document.getElementById('fantome1').onclick = '' ;}
    if($idFantome === 'fantome2'){
        document.getElementById('fantome2').className ='classGagnant2';
    } else { document.getElementById('fantome2').onclick = '' ;}
    if($idFantome === 'fantome3'){
        document.getElementById('fantome3').className ='classGagnant3';
    } else { document.getElementById('fantome3').onclick = '' ;}
    if($idFantome === 'fantome4'){
        document.getElementById('fantome4').className ='classGagnant4';
    } else { document.getElementById('fantome4').onclick = '' ;}
    if($idFantome === 'fantome3b'){
        document.getElementById('fantome3b').className ='classGagnant3b';
    } else { document.getElementById('fantome3b').onclick = '' ;}
    if($idFantome === 'fantome4b'){
        document.getElementById('fantome4b').className ='classGagnant4b';
    } else { document.getElementById('fantome4b').onclick = '' ;}
    if($idFantome === 'fantome5'){
        document.getElementById('fantome5').className ='classGagnant5';
    } else { document.getElementById('fantome5').onclick = '' ;}
    if($idFantome === 'fantome6'){
        document.getElementById('fantome6').className ='classGagnant6';
    } else { document.getElementById('fantome6').onclick = '' ;}
    if($idFantome === 'fantome5b'){
        document.getElementById('fantome5b').className ='classGagnant5b';
    } else { document.getElementById('fantome5b').onclick = '' ;}
    if($idFantome === 'fantome6b'){
        document.getElementById('fantome6b').className ='classGagnant6b';
    } else { document.getElementById('fantome6b').onclick = '' ;}
    document.getElementById('phraseFin').className ='classHide';

    /*    BOUTON DE RETOUR   s'affiche après 10 sec  */
    /*affichage du message de tirage au sort après 10 sec */
    myFunction();
    function myFunction() {
        setInterval(function(){
            document.getElementById('divResultatPhoto').className = "";
            document.getElementById('id_button').className = "btn_class";
            document.getElementById('imgResultat').className ="bonAchatGagnant";
        }, 2500);
    }
    // redirection vers la page d'accueil après 10 seconde
    var userRating = document.querySelector('.js-user-rating');
    var isAuthenticated = userRating.dataset.isAuthenticated;
if(isAuthenticated==='false'){
    retour();
}
    function retour() {
        setInterval(function(){
            window.location.href = 'http://localhost:8889/operationHalloween/public/accueilHalloween/'; //{{ path('accueilHalloween') }}
        }, 1000); //modifier 15000
    }

}

function getinfo() {
    var e = document.getElementById("nom_client");
    var strUser = e.value;
    /* Appel AJAX vers cryptocompare.com */
    var ajax=new XMLHttpRequest();
    console.log("readyState après new : "+ajax.readyState);
    /* Détection de l'avancement de l'appel */
    ajax.onreadystatechange=function() {
      console.log("readyState a changé et vaut : "+ajax.readyState)  
    }  
    /* Détection de la fin de l'appel */
    ajax.onload = function() {
      console.log("Appel AJAX terminé");
      console.log("  status : "+this.status);
      console.log("  response : "+this.response);    
      if (this.status == 200) { /* Le service a bien répondu */
        document.getElementById("commandes").innerHTML = this.response;
      }
    }
    /* Détection du timeout */
    ajax.ontimeout=function() {
      console.log("Le service n'a pas répondu à temps : nouvel essai dans 5 sec");     
      /* Relancer l'appel 5 secondes plus tard */
      setTimeout("getCours()", 5000); 
    }
      
    /* Préparation de la requête et envoi */
    var url=`test.php?id_nom=${strUser}`;
    ajax.open("GET", url, true);
    ajax.timeout=1000; /* Délai d'expiration à 1 seconde */
    ajax.send();
  }
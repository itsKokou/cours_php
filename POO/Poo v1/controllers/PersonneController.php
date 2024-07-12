<?php 
//1-Recoit et traite la request http  (GET|POST)
//2-Realise les fonctionnalites ==> Use Case
//3-Produit une Response ==> Charger une vue Html+css

require_once "./models/Personne.php";
require_once "./models/Professeur.php";
class PersonneController{
    
    public function listerPersonne(){
        //$persone=new Personne
        $persone=new Personne();
        //$persone-> ==> interface de l'objet
        $persone->setId(1);
        $persone->setNomComplet("Hawa");
        $prof=new Professeur;
        //$persone-> ==> interface de l'objet
        $prof->setId(1);
        $prof->setNomComplet("Bbw");
        $prof->setGrade("Ingenieur");
        $personnes=[$persone,$prof];

        //Reponse
        require_once "./views/liste.html.php";  
    }
}
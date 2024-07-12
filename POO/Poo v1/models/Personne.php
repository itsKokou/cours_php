<?php
//abstract 
  //Classe => La classe est non instanciable
             //Impossible $persone=new Personne();
  //Methode 
//final (Classe|Methode)=> 
   //Classe => est une classe qui ne peut pas avoir des classes Filles
     //Impossible de faire Professeur extends Personne
   //Methode 
class Personne{
    //Attributs Static
    private static int $nbrePers;
    //Attributs Instances
    protected int $id;
    protected string $nomComplet;

    //Constructeurs 
    //Pas de Surchage en Php
    public function __construct()
    {
        
    }
    /**
     * Get the value of nbrePers
     */ 
    public  static function getNbrePers()
    {
        return self::$nbrePers;
    }

   
    public  static function setNbrePers($nbrePers)
    {
        self::$nbrePers = $nbrePers;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;  // Java this.id ou id
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nomComplet
     */ 
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * Set the value of nomComplet
     *
     * @return  self
     */ 
    public function setNomComplet($nomComplet)
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function __toString()
    {
        return "ID : ".$this->id ."Nom Complet : ". $this->nomComplet;
    }
}
<?php 
class ArticleConfModel extends ArticleModel{
    private string $fournisseur;

    public function __construct()
    {
       //parent::setType('ArticleConf');
        $this->type='ArticleConf';
    }
    

    /**
     * Get the value of fournisseur
     */ 
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set the value of fournisseur
     *
     * @return  self
     */ 
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }
}
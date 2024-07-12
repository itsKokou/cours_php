<?php 
class ArticleConfModel extends ArticleModel{
    private $fournisseur;

    public function __construct()
    {
        parent::__construct();;
        $this->type='ArticleConf';
    }
    

    public function getFournisseur()
    {
        return $this->fournisseur;
    }


    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;

    }
}
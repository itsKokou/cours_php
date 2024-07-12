<?php 
class ArticleVenteModel extends ArticleModel{
    private string  $dateProd;
    public function __construct()
    {
       //parent::setType('ArticleConf');
        $this->type='ArticleVente';
    }

    /**
     * Get the value of dateProd
     */ 
    public function getDateProd()
    {
        return $this->dateProd;
    }

    /**
     * Set the value of dateProd
     *
     * @return  self
     */ 
    public function setDateProd($dateProd)
    {
        $this->dateProd = $dateProd;

        return $this;
    }
}
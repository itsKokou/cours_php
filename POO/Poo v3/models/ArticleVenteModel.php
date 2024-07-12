<?php 
class ArticleVenteModel extends ArticleModel{
    private  $dateProd;
    public function __construct()
    {
        parent::__construct();
        $this->type='ArticleVente';
    }


    public function getDateProd()
    {
        return $this->dateProd;
    }

    public function setDateProd($dateProd)
    {
        $this->dateProd = $dateProd;
    }
}
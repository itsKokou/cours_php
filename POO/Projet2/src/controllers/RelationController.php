<?php
namespace App\Controllers;
use App\Config\Controller;
use App\Models\Relation\ApprovisionnerModel;
use App\Models\Relation\ProduireModel;
use App\Models\Relation\UtiliserModel;
use App\Models\Relation\VendreModel;


class RelationController extends Controller{
    private ApprovisionnerModel $approvisionner;
    private ProduireModel $produire;
    private UtiliserModel $utiliser;
    private VendreModel $vendre;

    public function __construct(){
        parent::__construct();
        $this->approvisionner = new ApprovisionnerModel();
        $this->produire = new ProduireModel();
        $this->utiliser = new UtiliserModel();
        $this->vendre = new VendreModel();
    }

    public function listerApprovisionner(){
        return $this->approvisionner->findAll();
    }

    public function listerProduire(){
        return $this->produire->findAll();
    }

    public function listerVendre(){
        return $this->vendre->findAll();
    }

    public function findRelationById(int $id, int $choix=1){
        if($choix==1){
            $data = $this->listerApprovisionner();
        }elseif($choix==2){
            $data = $this->listerProduire();
        }else{
            $data = $this->listerVendre();
        }
        foreach ($data as $e) {
            if($e->getId()==$id){
                return  $e;
            }
        }
        return null;
    }


    public function listerApprovisionnerByArticle(int $idA){
        $apps = $this->listerApprovisionner();
        $tab = [];
        foreach ($apps as $app) {
            if($app->getArticleConfectionID()==$idA){
                $tab[] = $app;
            }
        }
        return $tab;
    }


    public function listerProduireByArticle(int $idA){
        $prods = $this->listerProduire();
        $tab = [];
        foreach ($prods as $prod) {
            if($prod->getArticleVenteID()==$idA){
                $tab[] = $prod;
            }
        }
        return $tab;
    }


    public function listerVendreByArticle(int $idA){
        $vends = $this->listerVendre();
        $tab = [];
        foreach ($vends as $vend) {
            if($vend->getArticleVenteID()==$idA){
                $tab[] = $vend;
            }
        }
        return $tab;
    }

    



    
}
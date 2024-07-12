<?php
require_once("./../models/operation/ApprovisionnementModel.php");
require_once("./../models/operation/ProductionModel.php");
require_once("./../models/operation/VenteModel.php");

class OperationController extends Controller{
    private ApprovisionnementModel $approvisionnement;
    private ProductionModel $production;
    private VenteModel $vente;

    public function __construct(){
        parent::__construct();
        $this->approvisionnement = new ApprovisionnementModel();
        $this->production = new ProductionModel();
        $this->vente = new VenteModel();
    }

    public function listerApprovisionnement(){
        return $this->approvisionnement->findAll();
    }

    public function listerProduction(){
        return $this->production->findAll();
    }

    public function listerVente(){
        return $this->vente->findAll();
    }


    public function findOperationById(int $id,int $choix=1){
        if($choix == 1){
            $data = $this->listerApprovisionnement();
        }elseif($choix==2){
            $data = $this->listerProduction();
        }else{
            $data = $this->listerVente();
        }
        foreach ($data as $e) {
            if($e->getId()==$id){
                return  $e;
            }
        }
        return null;
    }

    public function listerDate(int $choix = 1){
        if($choix == 1){
            $data = $this->listerApprovisionnement();
        }elseif($choix==2){
            $data = $this->listerProduction();
        }else{
            $data = $this->listerVente();
        }
        $dates = [];
        foreach($data as $d){
            if (! in_array($d->getDate(),$dates)){
                $dates[]=$d->getDate();
            }
        }
        return $dates;
    }

    public function listerOperationByDate(String $date, int $choix=1){
        if($choix == 1){
            $data = $this->listerApprovisionnement();
        }elseif($choix==2){
            $data = $this->listerProduction();
        }else{
            $data = $this->listerVente();
        }
        $appsF =[];
        foreach ($data as $app) {
            if($app->getDate()==$date){
                $appsF[] = $app;
            }
        }
        return $appsF;
    }



    public function listerApprovisionnementByFournisseur(int $idF){
        $apps = $this->listerApprovisionnement();
        $appsF =[];
        foreach ($apps as $app) {
            if($app->getFournisseurID()==$idF){
                $appsF[] = $app;
            }
        }
        return $appsF;
    }


    public function listerApprovisionnementByDateByFournisseur(String $date, int $idF){
        $apps = $this->listerOperationByDate($date);
        $appsF =[];
        foreach ($apps as $app) {
            if($app->getFournisseurID()==$idF){
                $appsF[] = $app;
            }
        }
        return $appsF;
    }

    

}
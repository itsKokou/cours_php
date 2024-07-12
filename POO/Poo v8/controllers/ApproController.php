<?php 
require_once './../models/ArticleConfModel.php';
require_once './../models/DetailApproModel.php';
require_once './../models/ApprovisionnementModel.php';
class ApproController extends Controller{
    private ArticleConfModel  $articleConfModel; 
    private ApprovisionnementModel $approModel;
    
    public function __construct()
    {
      parent::__construct();
      $this->articleConfModel=new ArticleConfModel;
      $this->approModel=new ApprovisionnementModel;
    }
    public function detailAppro(){
      
       try {
            $idAppro=$_GET['id-appro'];
            $appro= $this->approModel->findById($idAppro);
       } catch (\Throwable $th) {
          $this->redirect("appro");
       } 

       $this->renderView("appro/detail.htm.php",[
         "appro"=> $appro
     ]);
    }
    public function index(){
      $appro=$this->approModel->findApproByPaiement();
      $this->renderView("appro/liste.htm.php",[
         "appros"=>  $appro
     ]); 
    }
    //Ajouter  une Appro
    public function save(){

      //1.Charger le Formulaire ==>Request GET
      //2.Enregistrement des donnes du Formulaire  ==>  Request POST 
      if(isset($_POST['page']) && $_POST['page']=='save-appro'){
         //  $this->redirect("");
         if(Session::isset("details")){
            //Verier s'il existe des details
         $total=Session::get("total");
         $details= Session::get("details");
        //$json=file_get_contents('php://input');
        // $data= json_decode($jso,true);
         $this->approModel->montant= $total;
         $this->approModel->details=$details;
         try {
            if($this->approModel->insert()==1){
               //Vider Details
                 Session::unset("details");
                 Session::unset("total");
                 Session::set("sms","Approvisionnement ajoute avec succees");
           } else{
                 Session::set("sms","Erreur d'enregistrement ");
           }
         } catch (\Throwable $th) {
            //Capturer les exeptions de BD 
              Session::set("sms","Erreur d'enregistrement ");
         }
      }else{
         Session::set("sms","Veuillez au moins ajouter un article ");
      }
      }
      // if(isset($_GET['page']) && $_GET['page']=='save-appro'){
         $articles= $this->articleConfModel->findAll();
         $this->renderView("appro/form.htm.php",[
             "articles"=>$articles
         ]); 
      // }
    }

    //Lister  Appro Non Payer
    //Filtrer Par  Payement
    public function addDetail(){
       $article= $this->articleConfModel->findById($_POST['articleID']);
       //A Revoir
         $article=Helper::toObject(Helper::toArray($article));
        
           if(!Session::isset("details")){
             //Premier Ajout Ligne
              $details=[];
              $total=0;
           }
           else{
             //2,3,4 Ajout Ligne
               $details= Session::get("details");
               $total=Session::get("total");
           }
            $pos=$this->getDetailById($details, $_POST['articleID']);
            $montant=$article->prixAchat*$_POST['qteAppro'];
             if($pos==-1){
                $unDetail =[
                   "id"=>$_POST['articleID'],
                   "libelle"=> $article->libelle,
                   "prix"=>$article->prixAchat,
                   "qte"=>$_POST['qteAppro'],
                   "montant"=> $montant,
                   "qteStock"=> $article->qteStock,
                ];
                  $details[]= $unDetail;
             }else{
                $details[$pos]['qte']+=$_POST['qteAppro'];
                $details[$pos]['montant']+=$montant;
             }
             
             $total+=$montant;
             Session::set("total",$total);
             Session::set("details",  $details);
            $this->redirect("save-appro");
    }

    private function getDetailById(array $details,int $id):int{
          foreach( $details as $key=> $detail){
               if($detail['id']==$id){
                  return $key;
               }
          }
          return -1;
    }
    
}
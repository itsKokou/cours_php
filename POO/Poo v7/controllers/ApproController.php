<?php 
require_once './../models/ArticleModel.php';
require_once './../models/ArticleConfModel.php';
class ApproController extends Controller{
    private ArticleConfModel  $articleConfModel; 
    
    public function __construct()
    {
      parent::__construct();
      $this->articleConfModel=new ArticleConfModel;
    }
    //Ajouter  une Appro
    public function save(){
        $articles= $this->articleConfModel->findAll();
        $this->renderView("appro/form.htm.php",[
            "articles"=>$articles
        ]);    
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
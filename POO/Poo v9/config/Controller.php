<?php 

class Controller{
    protected $layout="base";
    public function __construct()
    {
      Session::start();
    }

    public function renderView(string $view,array $data=[]){
             ob_start();
             /**
              * $categores=$data['categories'];  ==>;  extract($data)
              */
              extract($data);
             require_once "./../views/$view";
             $contentForview=ob_get_clean();
             require_once "./../views/".$this->layout.".layout.html.php"; 
    }

    public function redirect(string $path){
         header("location:".BASE_URL."?page=$path");
         exit(); 
    }
}
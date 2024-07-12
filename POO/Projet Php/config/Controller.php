<?php

class Controller{
    protected $layout="base";
    public function __construct(){
      Session::start();
    }

    public function renderView(string $view,array $data=[]){
        ob_start();
          extract($data);
          require_once "./../views/$view.html.php";
        $contentForView=ob_get_clean();
        require_once "./../views/layout/".$this->layout.".layout.html.php"; 
    }


    public function redirect(string $path){
        header("location:".BASE_URL."?page=$path");
        exit(); 
    }
}
<?php
namespace App\Controllers;
use App\Config\Controller;

class NotFoundController extends Controller{

    public function __construct(){
        parent::__construct();
        $this->layout = "error";
    }

    public function _404(){
        $this->renderView("error/_404");
    }
}
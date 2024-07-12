<?php

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\ApproController;
use App\Controllers\ArticleController;
use App\Controllers\CategorieController;

require_once "./../vendor/autoload.php";
//Front Controller
require_once "./../src/core/bootsrap.php";

//Enregistrer les routes
Router::route("/article",[ArticleController::class,'lister']);
Router::route("/article/form",[ArticleController::class,'showForm']);
Router::route("/article/create",[ArticleController::class,'save']);

Router::route("/categorie",[CategorieController::class,'lister']);
Router::route("/categorie/create",[CategorieController::class,'add']);

Router::route("/login",[AuthController::class,'login']);
Router::route("/login/form",[AuthController::class,'showFormLogin']);
Router::route("/logout",[AuthController::class,'logout']);

Router::route("/appro",[ApproController::class,'index']);
Router::route("/appro/create",[ApproController::class,'save']);
Router::route("/appro/detail",[ApproController::class,'detailAppro']);
Router::route("/appro/payement",[ApproController::class,'validerPayement']);
Router::route("/appro/add/detail",[ApproController::class,'addDetail']);
//showFormLogin
//Resoudre route
Router::resolve();


//Lister les articles
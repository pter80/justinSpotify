<?php

namespace Controllers;

class IndexController extends Controller 

{
    public function Index()
    {
        //savoir si un utilisateur existe deja
        $sessionUser = false;
        if (isset($_SESSION['name'])) {
        //La variable name est déjà enregistrée !';
        $sessionUser = true;
        }


        echo $this->twig->render('index.html', ['sessionUser' => $sessionUser]);
    }
}

<?php

namespace Controllers;

class IndexController extends Controller 

{
    public function Index()
    {

        echo $this->twig->render('index.html', ['name' => 'Justin']);
    }
}
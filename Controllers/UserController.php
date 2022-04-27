<?php
namespace Controllers;

use Entity\User;
class UserController extends Controller

{
    public function create() //renvoi au formulaire de creation de compte utilisateur
    {
        echo $this->twig->render('formAccount.twig', []);

    }
    
    public function add($params)//recuperation donnees du formulaire d'ajout de compte et crée l'utilisateur dans la table User
    {
        $em=$params["em"];

        //récuper les données du form
        $name = $_POST["name"];
        $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $email = $_POST["email"];
        
        $qb=$em->createQueryBuilder();
        $qb->select('u')
        ->from('Entity\User', 'u')
        ->where('u.name =:name')
        ->setParameter('name', $name )
        ->setMaxResults(1)
        ;
        
        $query = $qb->getQuery();
        $user = $query->getOneOrNullResult();
       
        if($user){
        //le user existe deja
            echo $this->twig->render('formAccount.twig', []);
        }
        
        else{
            //le user n'existe pas, je le cree
            $user = new User();
            $user->setName($name);
            $user->setPassword($password);
            $user->setEmail($email);
            $em->persist($user);
            $em->flush();
            echo $this->twig->render('index.html',[]);

        }
    }

    public function login()
    {
        //renvoi au formulaire de connexion a un compte utilisateur
        echo $this->twig->render('formLogin.twig', []);
    
    }
    
    public function loginUser($params)//recupere les elements du formulaire de connexion et traite la demande
    {
        $em=$params["em"];


        if (isset($_SESSION['name'])) { 
            //Si une session utilisateur existe déja
            $name = $_SESSION['name'];
                
            //recuperation des donnees de l'utilisateur (groupes...)
            $qb=$em->createQueryBuilder();
            $qb->select('u')
            ->from('Entity\User', 'u')
            ->where('u.name =:name')
            ->setParameter('name', $name)
            ->setMaxResults(1);
            $query = $qb->getQuery();
            $user = $query->getOneOrNullResult(); 
            
            echo $this->twig->render('userAccount.twig',['name' =>$name, 'user' =>$user]);
    
        }
    
        else {
            
        //récupère les données du formulaire
            $name = $_POST["name"];
            $password = $_POST["password"];
            
            //vérifier si le compte existe dans la table
            $qb=$em->createQueryBuilder();
            $qb->select('u')
            ->from('Entity\User', 'u')
            ->where('u.name =:name')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ;
            
            $query = $qb->getQuery();
            $user = $query->getOneOrNullResult();
            
            $flagLogin = false; //si tout est ok, pas besoin de créer  
        
            if($user){ //si le user existe
            
                if (password_verify($password,$user->getPassword())) { //et si le mot de passe correspond
                    session_destroy();
                    
                    session_start(); //creation de la session
                    
                    $_SESSION["name"]=$name;
                    
                    echo $this->twig->render('userAccount.twig',['name' =>$name, 'user' =>$user ]);
                }
                else { //si le mdp est incorrecte
                    $flagLogin = true;
                    echo $this->twig->render('formLogin.twig',['flagLogin' =>$flagLogin]);
    
                }
                
            }
        
            else { //si le user n'existe pas
                $flagLogin = true;
                echo $this->twig->render('formLogin.twig',['flagLogin' =>$flagLogin]);
            }
        }
    }
    
    public function closeSession()//deconnexion d'un compte utilisateur
    {
        unset($_SESSION['name']); 
        echo $this->twig->render('index.html',[]);
    }

}
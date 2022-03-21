<?php

namespace Controllers;

use Entity\Artist;
use Entity\Genre;
use Entity\Top;
use Entity\User;

class TopDateController extends Controller 

{
    
    public function newliste($params)
  {
     
     //$pr = new Artist();
     //var_dump($pr);die;
     $em=$params["em"];
     
     
     $dql = "SELECT t.dt, COUNT(t.id) nb from Entity\TopDate t GROUP BY t.dt";
     //$query = $em->createQuery($dql)->SetMaxResults(50);
     $query = $em->createQuery($dql);
     $result=$query->getResult();
     //var_dump($result);
     $dts = $result;
     echo $this->twig->render('new_top_list.twig', ['dts'=>$dts]);
     
  }
  
   public function listeDate($params)
  {
     $em=$params["em"];
     
     
     $dql = "SELECT t.dt, COUNT(t.id) nb from Entity\TopDate t WHERE t.dt BETWEEN '2022-03-07 00:00:00' AND '2022-03-07 23:59:59'";
     //$query = $em->createQuery($dql)->SetMaxResults(50);
     $query = $em->createQuery($dql);
     $result=$query->getResult();
     //var_dump($result);
     $dts = $result;
     echo $this->twig->render('new_top_list.twig', ['dts'=>$dts]);
     
  }
    
     
     public function liste($params)
  {
     //$pr = new Artist();
     //var_dump($pr);die;
     $em=$params["em"];
     
     //okokokokokok
     
     
     $dql = "select t from Entity\TopDate t";
     $query = $em->createQuery($dql)->SetMaxResults(50);
     $result=$query->getResult();
     //var_dump($result);
     $tops = $result;
     echo $this->twig->render('top_list.twig', ['tops'=>$tops]);
     
  } 
  
    public function list()
    {

        $ch = curl_init("https://api.spotify.com/v1/me/top/artists?time_range=medium_term&limit=150&offset=5");
        $fp = fopen("./documents/top.json", "w");
        $token='BQDPPZcg8Xwn7wcKIFQsWlOJeeclVNQZzlgXSj_dG85R-_qscE73x2MXyIhWxUyKRYmT9a4otK9eKFBr6U1pLkYCIqIDgqb9pyy_adJgVeune9imM0AuPhpn3QqG7Jl-k7tMmQ-cma0gUbc3pQyE';
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/oauth2/token");
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); 
        curl_exec($ch);
        //curl_error($ch);
        //var_dump(curl_error($ch));
        if(curl_error($ch)) {
            echo "toto";
            $jason=curl_error($ch);
            //fwrite($fp, $jason);
            //var_dump(curl_error($ch));
            var_dump(json_decode(curl_error($ch), false));
        }
        curl_close($ch);
        fclose($fp);
        die;

        echo $this->twig->render('index.html', ['name' => 'Justin']);
    }
    
    
}
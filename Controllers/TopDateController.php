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
     echo $this->twig->render('new_list.twig', ['dts'=>$dts]);
     
  }
  
  //affiche les données du top pour une date donnée
   public function listeDate($params)
  {
     $em=$params["em"];
     $data=$params["get"]["dt"];
     //var_dump($data);
     $dql = "SELECT t from Entity\TopDate t WHERE t.dt BETWEEN :dt1 AND :dt2";
     //$query = $em->createQuery($dql)->SetMaxResults(50);
     $query = $em->createQuery($dql)->setParameter("dt1", $data." 00:00:00")->setParameter("dt2", $data." 23:59:59");
     //var_dump($query->getSql(),$query->getParameters()); die;
     //$query = $em->createQuery($dql);
     //echo $query->getSql();
     $result=$query->getResult();
     //var_dump(count ($result));
     $dts = $result;
     foreach ($dts as $key=>$dt){
         //var_dump($dt->getDt());
         $dts[$key]=array (
             "href" => "c=topDate&t=liste & dt=".$dt->getDt()->format("Y-m-d"),
             "dt" => $dt->getDt(),
             "artist" => $dt->getArtist(),
             );

     }
     //var_dump ($dts[0]["artist"]->getSpotifyId()); die ;
     echo $this->twig->render('new_top_list.twig', ['dts'=>$dts]);
     
  }
     
     public function liste($params)
  {
     //$pr = new Artist();
     //var_dump($pr);die;
     $em=$params["em"];
     
     
     $dql = "select t from Entity\TopDate t";
     $query = $em->createQuery($dql);
     $result=$query->getResult();
     //var_dump($result);
     $tops = $result;
     echo $this->twig->render('top_list.twig', ['tops'=>$tops]);
     
  } 
  
    public function list()
    {

        $ch = curl_init("https://api.spotify.com/v1/me/top/artists?time_range=medium_term&limit=150&offset=5");
        $fp = fopen("./documents/top.json", "w");
        $token='BQCaSPICx1RgsxRywtyvzCm5WxbCcPDGvH8jHkbQbZP6a3zylqoMhbRUrbRb6ZXIO-9_aamndUT8hNHceLT_fgmzjCWqiam-vla-LvadXWmPyAgiLe76W9279hMGp3L3hkZ8bvfCDx92OxRx7eqV';
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
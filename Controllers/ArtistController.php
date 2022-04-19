<?php 

namespace Controllers;

use Entity\Artist;
use Entity\Genre;
use Entity\Top;
use Entity\User;

class ArtistController extends Controller 

{
 
 public function show($params)
 {
     $em=$params["em"];
     $spotifyArtist= $params["get"]["id"];
     
     $qb = $em->createQueryBuilder();
     $qb->select("a")
        ->from ("Entity\Artist", "a")
        ->where ("a.spotify_id = '".$spotifyArtist."'")
        //->setParameter ("spotifyId",$spotifyArtist)
        ->setMaxResults(1);
        ;
        
    $query = $qb->getQuery();
    //var_dump($query->getSql()); die ;
    
    $results=$query->getResult();
    $artist= $results[0];
    //var_dump($results[0]->getId()); die;
    
     
     echo $this->twig->render('index.html', ['name' => 'Justin']);
     èy
 }
 
 
 public function showCurl($params)
    {

        $em=$params["em"];
        
        $spotifyArtist= $params["get"]["id"];
       // var_dump($spotifyArtist); die;

        $ch = curl_init("https://api.spotify.com/v1/artists/".$spotifyArtist);
        //$fp = fopen("./documents/top.json", "w");
        $token='BQBVeNdZiCKsHp23LX6lHTLGnD99wtcomvlM0ExwcBBq-qvmaTHKr_t-KFSLmd3IZtL16susN6PYE4OPgPSAMSV-Hl9HvaaswXdD7Pw9QRLHq36HFtTM2BhAdhv35JrdVYkfk0ElKlwUNtxkEKfP';
        //curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/oauth2/token");
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); 
        $result =curl_exec($ch);
        //var_dump(json_encode($result)); die;
        //curl_error($ch);
        //var_dump(curl_error($ch));
        if(curl_error($ch)) {
            $jason=curl_error($ch);
            //fwrite($fp, $jason);
            //var_dump(curl_error($ch));
            //var_dump(json_decode(curl_error($ch), false));
        }
        else {
            $artist=json_encode($result);
            var_dump("artist:",$artist->$uri);
        }
        curl_close($ch);
        fclose($fp);
        die;

        echo $this->twig->render('index.html', ['name' => 'Justin']);
    }
}
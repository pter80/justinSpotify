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
    //var_dump($results[0]->getExternalUrl()); die;
    $url = $results[0]->getExternalUrl();
    //var_dump($url); die;
     
 echo $this->twig->render('detailArtist.twig', ['artist'=>$artist]);
     
 }
 
 
 public function showCurl($params)
    {

        $em=$params["em"];
        
        $spotifyArtist= $params["get"]["id"];
       // var_dump($spotifyArtist); die;

        $ch = curl_init("https://api.spotify.com/v1/artists/".$spotifyArtist);
        //$fp = fopen("./documents/top.json", "w");
        $token='BQCD8D9R-ZnRC_vLlbQLzoZ0TarsgJSeLQqHB81PzTaeDrmbot1yRL4lyfeZU1-WU0A0JdmHp22zNtdJCAhclUaWuY2GNt_nFIFbQqW-ialKmnuDRIPN5BxDMatX1lgJXEfEECpGYMQtglSgcnMS';
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
<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Entity\Artist;
use Entity\Genre;
use Entity\TopDate;
use Entity\User;

$paths = array("src/Entity","toto");
$isDevMode = true;
$proxyDir=null;
$cache=null;
// configuration de connection
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'justin',
    'password' => 'bts2020',
    'dbname'   => 'justin',
);
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
//$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);


$file = "./documents/top.json"; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
$rows = json_decode($data); 
// accéder à l'élément approprié
$order=0;//permet de déterminer le classement des artistes
$dql="SELECT u FROM Entity\User u";
$qb=$em->createQuery($dql)->setMaxResults(1);
$user=$qb->getOneOrNullResult();
//si user est à null -> erreur 
foreach($rows->items as $spotify_artist) {
    $order++;
    //var_dump($spotify_artist->id);
    $qb= $em->createQueryBuilder();
    $qb->select('a')
       ->from('Entity\Artist', 'a')
       ->where('a.spotify_id=:spotify_id')
       ->setParameter('spotify_id', $spotify_artist->id)
       ;
    $query=$qb->getQuery();
    $artist=$query->getOneOrNullResult();
    if(!$artist) {
        $artist=new Artist();
    }
    $artist->setSpotifyId($spotify_artist->id);
    $artist->setName($spotify_artist->name);
    $artist->setFollowers($spotify_artist->followers->total);
    $artist->setExternalUrl($spotify_artist->external_urls->spotify);
    $artist->setPopularity($spotify_artist->popularity);
    $em->persist($artist);
    $em->flush();
    //envoyer le classement d'artistes dans TopDate
    $topDate= new TopDate();
    $topDate->setUser($user);
    $dt=new DateTime(date("Y-m-d"));
    var_dump($dt);
    $topDate->setDt($dt);
    $topDate->setClassement($order);
    $topDate->setArtist($artist);
    $em->persist($topDate);
    $em->flush();
    
    
    //var_dump($spotify_artist->genres);
    foreach ($spotify_artist->genres as $genre){
        //var_dump($genre);
        
        $qb= $em->createQueryBuilder();
        $qb->select('g')
            ->from('Entity\Genre', 'g')
            ->where('g.name=:name')
            ->setParameter('name', $genre)
            ->setMaxResults(1)
       ;
        
        $query=$qb->getQuery();
        //var_dump($query->getSql());
        $mygenre=$query->getOneOrNullResult();
        if(!$mygenre) {
            $mygenre=new Genre();
        }
        $mygenre->setName($genre);
        $em->persist($mygenre);
        //var_dump($artist->getArrayGenres(),$artist->addGenre($mygenre));
        $em->persist($artist);
        if(!in_array ($mygenre->getName(), $artist->getArrayGenres())){
            $artist->addGenre($mygenre);
            $em->persist($artist); 
        }
        
    }
    
    
    
    
    
    $em->flush();
    
    
    
    
    echo"***************************\n";
}




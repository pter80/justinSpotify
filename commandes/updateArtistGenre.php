<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Entity\Artist;
//use Entity\Product;

$paths = array("src/Entity","toto");
$isDevMode = true;
$proxyDir=null;
$cache=null;
// the connection configuration
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
//var_dump($params);die;


$dql="SELECT t FROM Entity\TopDate t";
$qb=$query = $em->createQuery($dql);
$artists=$qb->getResult();



foreach ($topDates as $topDates){
    
    $topDate->
    $qb= $em->createQueryBuilder();
    $qb->select('t')
       ->from('Entity\TopDates', 't')
       ->where('a.spotify_id')
}
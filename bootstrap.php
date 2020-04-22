<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), $isDevMode, null, null, false);
// or if you prefer XML
// $config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config"), $isDevMode);
// database configuration parameters
$conn = array(
    'driver' => 'mysqli',
//    'path' => __DIR__ . '/db.sqlite',
//    'path' => 'mysql://(host=localhost,user=root)/ingroup',
    'user' => 'root',
    'dbname' => 'ingroup'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);


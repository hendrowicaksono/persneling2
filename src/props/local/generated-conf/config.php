<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('slims', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;port=3306;dbname=slims',
  'user' => 'root',
  'password' => 's0beautifulday',
  'settings' =>
  array (
    'charset' => 'utf8mb4',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$manager->setName('slims');
$serviceContainer->setConnectionManager('slims', $manager);
$serviceContainer->setDefaultDatasource('slims');
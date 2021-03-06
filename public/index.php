<?php

// Autoload de composer
require '../vendor/autoload.php';

// Le fichier qui contient nos constante de configuration
require '../app/config/parameters.php';

// Variable d'environnement pour les message d'erreurs slim

if(ENV === "local"){
  define("CACHE", false);
  $env_error = true;
}elseif(ENV === "prod"){
  define("CACHE", true);
  $env_error = false;
}

// Configuration slim pour les messages d'erreurs
$configuration = [
  'settings' => [
    'displayErrorDetails' => $env_error,
  ],
];

// Initialisation des paramètres du container slim
$c = new \Slim\Container($configuration);
require '../app/config/errors.php';

// Initialisation de Slim
$app = new \Slim\App($c);

// Initialisation des sessions/cookies
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

// Le container qui compose nos librairies
require '../app/config/container.php';

// Appel des middlewares
require '../app/config/middlewares.php';

// Le fichier ou l'on déclare les routes
require '../app/config/routes.php';

// Execution de Slim
$app->run();

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Core\Router;
use App\Core\Database;
use App\Core\Session;
use App\Core\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


try {

    require __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    Database::init();


    Session::start();

    $loader = new FilesystemLoader(__DIR__ . '/../app/views');
    $twig = new Environment($loader, ['debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    View::setTwig($twig);

    $router = new Router();
    require __DIR__ . '/../config/routes.php';
    $router->dispatch();
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

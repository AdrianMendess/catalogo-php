<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProductController;

$controllerProduct = new ProductController();

// Pega o "action=" da URL (se não tiver nada, assume 'index')
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        require __DIR__ . '/../src/Views/products/create.php';
        break;
    case 'store':
        $controllerProduct->store();
        break;
    case 'edit':
        $controllerProduct->edit();
        break;
    case 'update':
        $controllerProduct->update();
        break;
    case 'delete':
        $controllerProduct->delete();
        break;
    case 'search':
        $controllerProduct->search();
        break;
    default:
        $controllerProduct->index();
        break;
}
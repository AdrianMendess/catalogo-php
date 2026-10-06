<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProductController;

$controller = new ProductController();

// Um roteamento básico via parâmetro URL `?action=` ou URI simples
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        require __DIR__ . '/../src/Views/products/create.php';
        break;
    case 'store':
        $controller->store();
        break;
    case 'delete':
        $controller->destroy();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}

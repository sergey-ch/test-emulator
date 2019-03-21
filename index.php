<?php
include_once __DIR__ .'/vendor/autoload.php';

$action = $_REQUEST['action'] ?? 'main';
$controller = new \Test\Controller();

if (method_exists($controller, 'action'. ucfirst($action))) {
    $controller->{'action'. ucfirst($action)}();
} else {
    http_response_code(404);
    exit;
}

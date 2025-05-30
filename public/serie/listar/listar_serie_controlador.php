<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Serie.php';

if (!isset($_GET['id_escola'])) {
    echo json_encode([]);
    exit;
}

$id_escola = $_GET['id_escola'];

$serie = new Serie();
$lista = $serie->buscar_serie_escola($id_escola);

header('Content-Type: application/json');
echo json_encode($lista);

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../../app/controller/Serie.php';


header('Content-Type: application/json');

try{
    $id_escola = $_GET['id_escola'] ?? null;
    $serieObj = new Serie();
    $series = $serieObj->buscar_serie_escola($id_escola);

    if ($series) {
        echo json_encode($series);
    } else {
        echo json_encode(null);
    }
}catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
<?php

require_once '../../../app/controller/Serie.php';

header('Content-Type: application/json');

try {
    $id_serie = $_GET['id_serie'] ?? null;

    $serieObj = new Serie();
    $serie = $serieObj->buscar_por_id($id_serie);

    if ($serie) {
        echo json_encode($serie);
    } else {
        echo json_encode(null);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

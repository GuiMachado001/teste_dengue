<?php

require_once '../../../app/controller/estado.php';

header('Content-Type: application/json');

try {
    $id_estado = $_GET['id_estado'] ?? null;

    $estadoObj = new Estado();
    $estado = $estadoObj->buscar_por_id($id_estado);

    if ($estado) {
        echo json_encode($estado);
    } else {
        echo json_encode(null);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

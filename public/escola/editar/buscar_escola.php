<?php

require_once '../../../app/controller/Escola.php';

header('Content-Type: application/json');

try {
    $id_escola = $_GET['id_escola'] ?? null;

    $escolaObj = new Escola();
    $escola = $escolaObj->buscar_por_id($id_escola);

    if ($escola) {
        echo json_encode($escola);
    } else {
        echo json_encode(null);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

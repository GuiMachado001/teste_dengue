<?php

require_once '../../../app/controller/cidade.php';

header('Content-Type: application/json');

try {
    $id_cidade = $_GET['id_cidade'] ?? null;

    $cidadeObj = new Cidade();
    $cidade = $cidadeObj->buscar_por_id($id_cidade);

    if ($cidade) {
        echo json_encode($cidade);
    } else {
        echo json_encode(null);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

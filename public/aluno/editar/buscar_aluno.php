<?php

require_once '../../../app/controller/Aluno.php';

header('Content-Type: application/json');

try {
    $id_aluno = $_GET['id_aluno'] ?? null;

    $alunoObj = new Aluno();
    $aluno = $alunoObj->buscar_por_id($id_aluno);

    if ($aluno) {
        echo json_encode($aluno);
    } else {
        echo json_encode(null);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

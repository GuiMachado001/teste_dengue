<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Aluno.php';


header('Content-Type: application/json');

try{
    $id_escola = $_GET['id_escola'] ?? null;
    $alunoObj = new Aluno();
    $alunos = $alunoObj->buscar_aluno_serie($id_escola);

    if ($alunos) {
        echo json_encode($alunos);
    } else {
        echo json_encode(null);
    }
}catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Aluno.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);
    $nome = trim($input['nome'] ?? '');
    $id_serie = trim($input['id_serie'] ?? '');

    if (!$nome || !$id_serie) {
        http_response_code(400);
        echo json_encode(['message' => 'Nome do aluno e série são obrigatórios.']);
        exit;
    }

    try {
    $controller = new Aluno();
    $resultado = $controller->cadastrar($nome, (int)$id_serie);

        if ($resultado) {
            echo json_encode(['message' => 'Aluno cadastrado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Erro ao cadastrar aluno']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Erro interno: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido']);
}

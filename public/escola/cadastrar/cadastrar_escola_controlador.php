<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Escola.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);
    $nome = $input['nome'] ?? '';
    $id_cidade = $input['id_cidade'] ?? '';
    
    if (!$nome || !$id_cidade) {
        http_response_code(400);
        echo json_encode(['message' => 'Nome da cidade e cidade são obrigatórios.']);
        exit;
    }

    $controller = new Cidade();
    $controller->nome = $nome;
    $controller->id_cidade = $id_cidade;

    // Tentar cadastrar
    if ($controller->cadastrar()) {
        echo json_encode(['message' => 'cidade cadastrado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao cadastrar o cidade!']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido']);
}
?>

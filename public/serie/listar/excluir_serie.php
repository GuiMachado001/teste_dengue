<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../../../app/controller/Serie.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $id_serie = $input['id_serie'] ?? null;

    if (!$id_serie) {
        echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
        exit;
    }

    $serie = new Serie();
    $serie->id_serie = $id_serie;

    $resultado = $serie->excluir();

    if ($resultado === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Esta serie possui alunos vinculadas. Exclua os alunos antes de excluir a serie.'
        ]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}

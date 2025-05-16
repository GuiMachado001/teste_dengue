<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../../../app/controller/estado.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $id_estado = $input['id_estado'] ?? null;

    if (!$id_estado) {
        echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
        exit;
    }

    $estado = new Estado();
    $estado->id_estado = $id_estado;

    $resultado = $estado->excluir();

    if ($resultado === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Este estado possui cidades vinculadas. Exclua as cidades antes de excluir o estado.'
        ]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}

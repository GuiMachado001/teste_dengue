<?php

require_once '../../../app/model/Database.php';

header('Content-Type: application/json');

try {
    $db = new Database('serie');

    if (isset($_GET['id_escola']) && is_numeric($_GET['id_escola'])) {
        $id_escola = intval($_GET['id_escola']);
        // filtra séries da escola
        $series = $db->select('id_escola = '.$id_escola)->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // retorna todas as séries se não passar id_escola
        $series = $db->select()->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode($series);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar séries']);
}

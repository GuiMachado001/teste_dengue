<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Aluno.php';

if (!isset($_GET['id_escola'])) {
    echo json_encode([]);
    exit;
}

$id_escola = $_GET['id_escola'];

$aluno = new Aluno();
$lista = $aluno->buscar_aluno_escola($id_escola);

header('Content-Type: application/json');
echo json_encode($lista);

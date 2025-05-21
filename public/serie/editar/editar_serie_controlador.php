<?php

require_once '../../../app/controller/Serie.php';

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id_serie']) || !isset($data['nome'])){
    echo 'dados inválidos';
    exit;
}

$serie = new Serie();
$serie->id_serie = intval($data['id_serie']);
$serie->nome = $data['nome'];

if($serie->atualizar()){
    echo json_encode(['success' => true, 'message' => 'serie atualizado com sucesso']);
}else{
    echo 'Erro ao atualizar o serie.';
}
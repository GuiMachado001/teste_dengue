<?php

require_once '../../../app/controller/Aluno.php';

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id_aluno']) || !isset($data['nome'])){
    echo 'dados inválidos';
    exit;
}

$aluno = new Aluno();
$aluno->id_aluno = intval($data['id_aluno']);
$aluno->nome = $data['nome'];

if($aluno->atualizar()){
    echo json_encode(['success' => true, 'message' => 'aluno atualizado com sucesso']);
}else{
    echo 'Erro ao atualizar o aluno.';
}
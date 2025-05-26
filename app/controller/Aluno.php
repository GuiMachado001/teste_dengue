<?php

require_once __DIR__ . '/../model/Database.php';

class Aluno{
    public int $id_aluno;
    public int $id_serie;
    public string $nome;

public function cadastrar(string $nome, int $id_serie){
    $this->nome = $nome;
    $this->id_serie = $id_serie;

    $db = new Database('aluno');

    $res = $db->insert([
            'nome' => $this->nome,
            'id_serie' => $this->id_serie
        ]
    );
    return $res;
}

    public function buscar($where = null, $order = null, $limit = null ){
        $db = new Database('aluno');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }
    public function buscar_por_id($id){
        $db = new Database('aluno');

        if(is_numeric($id) && $id>0){
            $obj = $db->select('id_aluno = '.$id)->fetchObject(self::class);

            if($obj){
                return $obj;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

public function buscar_aluno_serie($id_escola){
    if(is_numeric($id_escola) && $id_escola > 0){
        $db = new Database();
        return $db->select_alunos_por_serie($id_escola);
    }

    return null;
}

    public function atualizar(){
        $db = new Database('aluno');

        $res = $db->update("id_aluno =".$this->id_aluno,
                            [
                                "nome" => $this->nome,
                            ]
                        );

        return $res;
    }


public function excluir(){
    try {
        $db_geral = new Database('');
        $resPontosAlunos = $db_geral->excluir_pontos_aluno($this->id_aluno);

        $db = new Database('aluno');
        return $db->delete('id_aluno = ' . $this->id_aluno);
    } catch (Exception $e) {
        // Log do erro, se desejar
        return false;
    }
}


}

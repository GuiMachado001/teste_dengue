<?php

require_once __DIR__ . '/../model/Database.php';

class Cidade{
    public int $id_cidade;
    public int $id_estado;
    public string $nome;

    public function cadastrar(){
        $db = new Database('cidade');

        $res = $db->insert([
                'nome' => $this->nome,
                'id_estado' => $this->id_estado
            ]
        );
        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null ){
        $db = new Database('cidade');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }
    public function buscar_por_id($id){
        $db = new Database('cidade');

        if(is_numeric($id) && $id>0){
            $obj = $db->select('id_cidade = '.$id)->fetchObject(self::class);

            if($obj){
                return $obj;
            }else{
                return null;
            }
        }else{
            return null;
        }

    }

    public function atualizar(){
        $db = new Database('cidade');

        $res = $db->update("id_cidade =".$this->id_cidade,
                            [
                                "nome" => $this->nome,
                            ]
                        );

        return $res;
    }

    public function excluir(){
        $db = new Database('cidade');
        return $db->delete('id_cidade ='.$this->id_cidade);
    }

    public function buscar_com_estado() {
        $db = new Database('');

        // $cidade_estado = $db->select_cidade_estado();
        
        return $db->select_cidade_estado();
    }
}

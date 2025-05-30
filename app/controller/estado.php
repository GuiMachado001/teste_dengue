<?php

require_once __DIR__ . '/../model/Database.php';

class Estado{
    public int $id_estado;
    public string $nome;

    public function cadastrar(){
        $db = new Database('estado');

        $res = $db->insert([
                'nome' => $this->nome
            ]
        );
        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null ){
        $db = new Database('estado');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }
    public function buscar_por_id($id){
        $db = new Database('estado');

        if(is_numeric($id) && $id>0){
            $obj = $db->select('id_estado = '.$id)->fetchObject(self::class);

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
        $db = new Database('estado');

        $res = $db->update("id_estado =".$this->id_estado,
                            [
                                "nome" => $this->nome,
                            ]
                        );

        return $res;
    }

    public function excluir(){
        $db = new Database('estado');
        return $db->delete('id_estado ='.$this->id_estado);
    }
}
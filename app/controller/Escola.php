<?php

require_once __DIR__ . '/../model/Database.php';

class Escola{
    public int $id_escola;
    public int $id_cidade;
    public string $nome;

    public function cadastrar(){
        $db = new Database('escola');

        $res = $db->insert([
                'nome' => $this->nome,
                'id_cidade' => $this->id_cidade
            ]
        );
        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null ){
        $db = new Database('escola');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }
    public function buscar_por_id($id){
        $db = new Database('escola');

        if(is_numeric($id) && $id>0){
            $obj = $db->select('id_escola = '.$id)->fetchObject(self::class);

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
        $db = new Database('escola');

        $res = $db->update("id_escola =".$this->id_escola,
                            [
                                "nome" => $this->nome,
                            ]
                        );

        return $res;
    }

    public function excluir() {
        $db = new Database('escola');

        $series = $db->verificar_series($this->id_escola);
        if ($series > 0) {
            return false;
        }


        $db_geral = new Database();
        $resPontos = $db_geral->excluir_pontos_escola($this->id_escola);

        // Se a exclusão dos pontos foi bem-sucedida, então excluir a escola
        return $db->delete('id_escola = ' . $this->id_escola);
    }

    public function buscar_com_cidade() {
        $db = new Database('');

        // $escola_estado = $db->select_escola_estado();
        
        return $db->select_escola_cidade();
    }

    public function ativar(){
        $db = new Database('escola');
        return $db->update('id_escola = ' . $this->id_escola, ['ativo' => 1]);
    }

    public function inativar(){
        $db = new Database('escola');
        return $db->update('id_escola = ' . $this->id_escola, ['ativo' => 0]);
    }
}

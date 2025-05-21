<?php

require_once __DIR__ . '/../model/Database.php';

class Serie{
    public int $id_serie;
    public int $id_escola;
    public string $nome;

    public function cadastrar(){
        $db = new Database('serie');

        $res = $db->insert([
                'nome' => $this->nome,
                'id_escola' => $this->id_escola
            ]
        );
        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null ){
        $db = new Database('serie');
        $res = $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        return $res;
    }
    public function buscar_por_id($id){
        $db = new Database('serie');

        if(is_numeric($id) && $id>0){
            $obj = $db->select('id_serie = '.$id)->fetchObject(self::class);

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
        $db = new Database('serie');

        $res = $db->update("id_serie =".$this->id_serie,
                            [
                                "nome" => $this->nome,
                            ]
                        );

        return $res;
    }

    public function excluir() {
        $db = new Database('serie');

        $series = $db->verificar_series($this->id_serie);
        if ($series > 0) {
            return false;
        }


        $db_geral = new Database();
        $resPontos = $db_geral->excluir_pontos_serie($this->id_serie);

        // Se a exclusão dos pontos foi bem-sucedida, então excluir a serie
        return $db->delete('id_serie = ' . $this->id_serie);
    }

    public function buscar_com_escola() {
        $db = new Database('');

        // $serie_estado = $db->select_serie_estado();
        
        return $db->select_serie_escola();
    }

    public function ativar(){
        $db = new Database('serie');
        return $db->update('id_serie = ' . $this->id_serie, ['ativo' => 1]);
    }

    public function inativar(){
        $db = new Database('serie');
        return $db->update('id_serie = ' . $this->id_serie, ['ativo' => 0]);
    }
}

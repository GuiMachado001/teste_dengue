<?php

    class Database{
    private $conn;
    private $table;

    private string $local;
    private string $db;
    private string $user;
    private string $password;

        function __construct($table = null) {
            $this->table = $table;
            $this->set_conn();
            $this->conecta();
        }

        function set_conn() {
            $envPath = dirname(__DIR__, 2) . '/.env'; // Sobe duas pastas
            $env = parse_ini_file($envPath);

            if (!$env) {
                throw new Exception("Erro ao carregar o arquivo .env. Verifique a sintaxe.");
            }

            $this->local = $env['DB_HOST'];
            $this->db = $env['DB_DATABASE'];
            $this->user = $env['DB_USER'];
            $this->password = $env['DB_PASSWORD'];
        }

        public function conecta(){
            try{

                $this->set_conn();

                $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo 'conectado com sucesso';
            }
            catch(PDOException $err){
                throw new Exception("Erro de conexão: " . $err->getMessage());
            }
        }

        public function execute($query, $binds = []){
            // echo $query;

            try{
                $stmt = $this->conn->prepare($query);
                $stmt->execute($binds);
                return $stmt;
            }catch(PDOException $err){
                throw new Exception("Erro de conexão: " . $err->getMessage());
            }
        }

        public function insert($values){
            $fields = array_keys($values);
            $binds = array_pad([], count($fields), '?');

            $query = 'INSERT INTO '.$this->table . '('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
            $res = $this->execute($query, array_values($values));

            if($res){
                return true;
            }else{
                return false;
            }
        }

        public function select($where = null, $order = null, $limit = null, $fields = '*'){
            $where = $where ? 'WHERE ' . $where : '';
            $order = $order ? 'ORDER BY' . $order : '';
            $limit = $limit ? 'LIMIT' . $limit : '';

            $query = 'SELECT '.$fields.' FROM '.$this->table. ' '.$where.' '.$order. ' '.$limit ;

            return $this->execute($query);
        }

        public function select_by_id($where = null, $order = null, $limit = null, $fields = '*'){
            $where = strlen($where) ? 'WHERE '.$where : '';
            $order = strlen($order) ? 'ORDER BY '.$order : '';
            $limit = strlen($limit) ? 'LIMIT '.$limit : '';
    
            $query = 'SELECT '.$fields.' FROM '.$this->table. ' '.$where. ' '.$order . ' '.$limit ;
    
            return $this->execute($query)->fetch(PDO::FETCH_ASSOC);
        }

        public function select_cidade_estado(){
            $query = "
                SELECT 
                    cidade.id_cidade,
                    cidade.nome AS nome_cidade,
                    estado.nome AS nome_estado
                FROM cidade
                INNER JOIN estado ON cidade.id_estado = estado.id_estado
                ORDER BY cidade.nome ASC
            ";
            return $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);

        }

        public function select_escola_cidade(){
            $query = "
                SELECT 
                    escola.id_escola,
                    escola.ativo,
                    escola.nome AS nome_escola,
                    cidade.nome AS nome_cidade
                FROM escola
                INNER JOIN cidade ON escola.id_cidade = cidade.id_cidade
                ORDER BY escola.nome ASC
            ";
            return $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);

        }

        public function select_serie_escola(){
            $query = "
                SELECT 
                    serie.id_serie,
                    serie.nome AS nome_serie,
                    escola.nome AS nome_escola
                FROM serie
                INNER JOIN escola ON serie.id_escola = escola.id_escola
                ORDER BY serie.nome ASC
            ";
            return $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);
        }

        public function verificar_series($id_escola) {
            $query = "SELECT COUNT(*) AS total FROM serie WHERE id_escola = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $id_escola]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            return $res['total'] ?? 0;
        }

        public function excluir_pontos_escola($id_escola){
            $query = "DELETE FROM pontos_escola WHERE id_escola = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':id' => $id_escola]);
        }

        public function update($where, $array){

            $fields = array_keys($array);
            $values = array_values($array);
            //Montar Query
            $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields). '=? WHERE '. $where;
    
            $res = $this->execute($query, $values);
            return $res->rowCount();
        }

        public function delete($where){

            $query = 'DELETE FROM '.$this->table. ' WHERE '.$where;
            
            $del = $this->execute($query);
            $del = $del->rowCount();

            if($del == 1){
                return true;
            }else{
                return false;
            }
        }


    }



?>
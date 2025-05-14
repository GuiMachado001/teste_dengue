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

        public function selete($where){
            $query = 'DELETE FROM '.$this->table. ' WHERE '.$where;
            $del = $this->execute($query);
            $del = $del->rowCount();

            if($del == 1){
                return true;
            }else{
                return false;
            }
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
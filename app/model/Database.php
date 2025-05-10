<?php

    class Database{
        private $conn;
        private string $local = '185.211.7.154'; 
        private string $db = 'u122259692_contradenguedb';
        private string $user = 'u122259692_agentadmindeng';
        private string $password = '95agen!C0ntr@dengu387';
        private $table;

        // private $conn;
        // private string $local = 'localhost'; 
        // private string $db = 'dengue';
        // private string $user = 'devweb';
        // private string $password = 'suporte@22';
        // private $table;

        function __construct($table = null){
            $this->table = $table;
            $this->conecta();
        }

        public function conecta(){
            try{
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
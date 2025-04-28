<?php

    class Database{
        private $conn;
        private string $local = 'localhost';
        private string $db = 'dengue';
        private string $user = 'devweb';
        private string $password = 'suporte@22';
        private $table;

        function __construct($table = null){
            $this->table = $table;
            $this->conecta();
        }

        public function conecta(){
            try{
                $this->conn = new PDO("mysql:host=".$this->local.";dbname=$this->db",$this->user,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'conectado com sucesso';
            }
            catch(PDOException $err){
                die("Connection Failed". $err->getMessage());
            }
        }
    }



?>
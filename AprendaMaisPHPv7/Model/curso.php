<?php
    require_once('conexao.php');

    class Curso{
        private $conn;

        public function __construct(){
            $dataBase = new dataBase();
            $this->conn = $dataBase->dbConnection();
        }

        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }

        public function insert($nome){
            try{
                $sql = "INSERT INTO curso(nome, idinstituicao)
                VALUES(:nome, 1)";                
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();
                return $stmt;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function deletar($idcurso){
            try{
                $sql = "DELETE FROM curso where idcurso = :idcurso";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idcurso', $idcurso);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function editar($nome, $idcurso){
            try{
                $sql = "UPDATE curso SET
                        nome = :nome
                        WHERE idcurso = :idcurso";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':idcurso', $idcurso);
                $stmt->execute();
                return $stmt;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function getAllCursos() {
            try{
                $query = "SELECT * FROM curso";
                $result = $this->conn->query($query);
                return $result->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function redirect($url){
            header("Location: $url");
        }        
    }
?>
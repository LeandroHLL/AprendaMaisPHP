<?php
    require_once '../model/professor.php';   
    $objProfessor = new Professor();

    if(isset($_POST['insertProfessor'])){
        $nome = $_POST['txtNome'];
        $email = $_POST['txtEmail'];
        if($objProfessor -> insert($nome,$email)){
            $objProfessor -> redirect('../Template/professor.php');
        }
    }

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objProfessor -> deletar($id)){
            $objProfessor -> redirect('../Template/professor.php');  
        }
    }

    if(isset($_POST['updateId'])){
        $nome = $_POST['txtNome'];
        $email = $_POST['txtEmail'];
        $id = $_POST['updateId'];
        if($objProfessor -> editar($nome,$email,$id)){
            $objProfessor -> redirect('../Template/professor.php');
        }
    }

?>
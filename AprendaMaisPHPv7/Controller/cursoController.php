<?php
    require_once '../model/curso.php';   
    $objCurso = new Curso();

    if(isset($_POST['insert'])){
        $nome = $_POST['txtNome'];
        if($objCurso -> insert($nome)){
            $objCurso -> redirect('../Template/curso.php');
        }
    }

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objCurso -> deletar($id)){
            $objCurso -> redirect('../Template/curso.php');  
        }
    }

    if(isset($_POST['updateId'])){
        $nome = $_POST['txtNome'];
        $id = $_POST['updateId'];
        if($objCurso -> editar($nome,$id)){
            $objCurso -> redirect('../Template/curso.php');
        }
    }

?>
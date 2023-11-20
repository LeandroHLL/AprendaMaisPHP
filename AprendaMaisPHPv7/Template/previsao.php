<?php
    //ini_set("display_errors", 1);
    require_once('../Model/turma.php');
    $objTurmas = new Turma();   
    //$result = $objCurso->getAllCursos();
    //var_dump($result,"<br>");

    //foreach ($result as $array) {
      //var_dump($array,"<br>");
    //}
    //exit();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Aprenda Mais - Ferramenta de Análise de Dados</title>
</head>
<body>
<?php 
  include('navegacao.php');
?>
<div class="container">
  <h2>Análise de Risco</h2>
  <p>Somente disponivéis para turmas em andamento</p>
  <p class="ml-2">
  <?php 
        $query = "SELECT idturma,nome,tipodeturma FROM turma
        where tipodeturma = 'A'";
        $stmt = $objTurmas->runQuery($query);
        $stmt->execute();
        $objTurmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form action="../controller/previsaoController.php" method="post">
    <input type="hidden" name="calcularPrevisao">
        <label>Escolha turma:</label>
        <select name="turma" id="idturma" onchange="pesquisar();">
        <?php foreach ($objTurmas as $objTurma) { ?>
            <option value="<?php echo($objTurma['idturma']);?>">
            <?php echo($objTurma['nome']);?></option>
        <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary">Executar</button>
    </form>
</div>
<script src="../Javascript/finder.js"></script>
</body>
</html>
<?php
require_once('../Model/turma.php');
$objTurma = new Turma();
require_once('../Model/curso.php');
$objCursos = new Curso();
require_once('../Model/disciplina.php');
$objDisciplinas = new Disciplina();
require_once('../Model/professor.php');
$objProfessores = new Professor();
require_once('../Model/aluno.php');
$objAluno = new Aluno();

$selectedTurma = isset($_POST['turma']) ? $_POST['turma'] : null;
$selectedOrder = isset($_POST['order']) ? $_POST['order'] : 'matricula';

$alunos = [];
if ($selectedTurma) {
    $queryAlunos = "SELECT A.* FROM aluno A
                    INNER JOIN desempenho_aluno_turma D ON A.matricula = D.matricula
                    WHERE D.idturma = :idturma
                    ORDER BY $selectedOrder";
    $stmtAlunos = $objAluno->runQuery($queryAlunos);
    $stmtAlunos->bindParam(':idturma', $selectedTurma, PDO::PARAM_INT);
    $stmtAlunos->execute();
    $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <?php include('navegacao.php'); ?>
    <div class="container">
        <h2>Análise de Risco</h2>
        <p>Somente disponivéis para turmas em andamento</p>
        <form method="post" class="form-inline">
            <div class="form-group mr-2">
                <label for="turma" class="mr-2">Selecione a turma:</label>
                <select name="turma" id="turma" class="form-control">
                    <?php
                    $queryTurmas = "SELECT idturma,nome,tipodeturma FROM turma
                    where tipodeturma = 'A'";
                    $stmtTurmas = $objTurma->runQuery($queryTurmas);
                    $stmtTurmas->execute();
                    $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($turmas as $turma) {
                        $selected = ($selectedTurma == $turma['idturma']) ? 'selected' : '';
                        echo "<option value='{$turma['idturma']}' $selected>{$turma['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="order" class="mr-2">Ordem:</label>
                <select name="order" id="order" class="form-control">
                    <option value="matricula" <?php echo ($selectedOrder == 'matricula') ? 'selected' : ''; ?>>Por Matrícula</option>
                    <option value="nome" <?php echo ($selectedOrder == 'nome') ? 'selected' : ''; ?>>Por Nome</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
            <button type="button" class="btn btn-primary ml-2" onclick="calcularPrevisaoTodos()">Calcular Previsão</button>
        </form>
        <div class="alert alert-info" role="alert">
            <strong>Total de Alunos:</strong> <?php echo count($alunos); ?>
        </div>

        <!-- Tabela de alunos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($alunos as $aluno) {
                    echo "<tr>";
                    echo "<td>{$aluno['matricula']}</td>";
                    echo "<td>{$aluno['nome']}</td>";
                    echo "<td>{$aluno['telefone']}</td>";
                    echo "<td>{$aluno['email']}</td>";
                    echo "<td>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
    function calcularPrevisaoTodos() {
        // Adapte a lógica conforme necessário
        alert("Calcular previsão para todos os alunos");
    }

    function calcularPrevisao(matricula, idTurma) {
        $.ajax({
            type: "POST",
            url: "../Controller/previsaoController.php", // Substitua pelo caminho correto para o seu arquivo
            data: {
                calcularPrevisao: true,
                matricula: matricula,
                turma: idTurma
            },
            success: function(response) {
                // Exiba a resposta onde você quiser, por exemplo, em um alert ou modal
                alert(response);
            },
            error: function() {
                alert("Erro ao calcular a previsão.");
            }
        });
    }
</script>
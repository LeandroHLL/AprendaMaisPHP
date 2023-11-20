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
    <!-- Remova a linha abaixo, pois o Bootstrap já inclui o jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            <!-- <button type="button" class="btn btn-primary ml-2" onclick="calcularPrevisaoTodos()">Calcular Previsão</button> -->
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
                    echo "<tr id='aluno_{$aluno['matricula']}'>";
                    echo "<td>{$aluno['matricula']}</td>";
                    echo "<td>{$aluno['nome']}</td>";
                    echo "<td>{$aluno['telefone']}</td>";
                    echo "<td>{$aluno['email']}</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary' onclick='calcularPrevisao(\"{$aluno['matricula']}\", \"{$selectedTurma}\")'>Calcular Previsão</button>";
                    echo "</td>";
                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalhes do Aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="matricula-turma-info"></p>
                    <label for="falta">Faltas:</label>
                    <input type="text" id="falta" class="form-control" readonly>

                    <label for="nota">Expectativa de notas:</label>
                    <input type="text" id="nota" class="form-control" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // function calcularPrevisaoTodos() {
        //     // Adapte a lógica conforme necessário
        //     alert("Calcular previsão para todos os alunos");
        // }
        function calcularPrevisao(matricula, idTurma) {
            // Abre o modal
            $('#myModal').modal('show');

            // Exibe as informações no modal
            var info = "Matrícula: " + matricula + "<br>Turma: " + idTurma;
            $('#matricula-turma-info').html(info);

            // Adicione aqui a lógica para fazer a requisição AJAX se necessário
            // ...
        }
    </script>
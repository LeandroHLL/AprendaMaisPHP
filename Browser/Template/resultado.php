    <?php
    session_start();
    require_once('../Model/turma.php');
    $objTurma = new Turma();
    require_once('../Model/disciplina.php');
    $objDisciplina = new Disciplina();
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
        <!-- Adicione a biblioteca Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Aprenda Mais - Ferramenta de Análise de Dados</title>
        <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
    </head>

    <body>
        <?php
        include('navegacao.php');
        ?>
        <div class="container">
            <thead></thead>
            <?php
            $idTurma = $_SESSION['idTurma'];

            $connection = new PDO("mysql:host=localhost;dbname=aprendendoMaisPhp4", "root", "");

            $query = "SELECT nome, percentualregresso, iddisciplina FROM turma WHERE idturma = {$_SESSION['idTurma']}";
            $stmt = $connection->query($query);
            $objTurma = $stmt->fetch(PDO::FETCH_ASSOC);
            $objDisciplina = $objDisciplina->getDisciplinaByid($objTurma['iddisciplina']);

            // Utilize a conexão direta para obter os dados de desempenho
            $queryDesempenho = "SELECT nota, falta FROM desempenho_aluno_turma WHERE idturma = $idTurma";
            $stmtDesempenho = $connection->query($queryDesempenho);
            $dadosDesempenho = $stmtDesempenho->fetchAll(PDO::FETCH_ASSOC);

            $notas = array_column($dadosDesempenho, 'nota');
            $faltas = array_column($dadosDesempenho, 'falta');
            ?>

            <body>
                <div class="container">
                    <h4 class="text-center">Tuma Analisada: <?php echo ($objTurma['nome']); ?> </h4>
                    <h1 class="text-center">Resultado da Análise: <?php echo ($objTurma['percentualregresso']); ?></h1>
                    <h5 class="text-center">Disciplina : <?php echo ($objDisciplina['nome']); ?></h5>
                    //
                    <div class="text-center mt-4">
                        <canvas id="scatterChart" width="200" height="100"></canvas>
                    </div>
                    //
                    <div class="row mt-2">
                        <div class="text-center mt-2 col-md-4">
                            <label for="resultados-negativos"><strong>Negativo ou Positivo:</strong></label>
                            <ul id="resultados-negativos" class="list-group">
                                <?php
                                if ($objTurma['percentualregresso'] < 0) {
                                ?>
                                    <li class="list-group-item">O valor é <strong>Negativo</strong>
                                        <p>O que podemos obter de interpretação é à medida que as notas aumentam,
                                            a quantidade de faltas tende a diminuir, e vice-versa.</p>
                                    </li>
                                <?php
                                } elseif ($objTurma['percentualregresso'] > 0) {
                                ?>
                                    <li class="list-group-item">O valor é <strong>Positivo</strong>
                                        <p>O que podemos obter de interpretação é à medida que as notas aumentam,
                                            a quantidade de faltas tende a aumentar, e vice-versa.</p>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="list-group-item">O valor é <strong>Neutro</strong>
                                        <p>O valor de regressão é neutro, sem uma tendência clara entre notas e faltas.</p>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="text-center mt-2 col-md-4">
                            <label for="resultados-negativos"><strong>Quanto mais próximo de 1</strong></label>
                            <ul id="resultados-negativos" class="list-group">
                                <?php
                                if ($objTurma['percentualregresso'] >= 0.7) {
                                ?>
                                    <li class="list-group-item">O valor obtido é
                                        <strong><?php echo ($objTurma['percentualregresso']); ?></strong>
                                        <p>O fato de o coeficiente de correlação estar próximo de 1 indica uma correlação muito forte.</p>
                                    </li>
                                <?php
                                } elseif ($objTurma['percentualregresso'] >= 0.4 && $objTurma['percentualregresso'] < 0.7) {
                                ?>
                                    <li class="list-group-item">O valor obtido é
                                        <strong><?php echo ($objTurma['percentualregresso']); ?></strong>
                                        <p>O fato de o coeficiente de correlação estar entre 0.4 e 0.7 indica uma correlação moderada.</p>
                                    </li>
                                <?php
                                } elseif ($objTurma['percentualregresso'] >= 0 && $objTurma['percentualregresso'] < 0.4) {
                                ?>
                                    <li class="list-group-item">O valor obtido é
                                        <strong><?php echo ($objTurma['percentualregresso']); ?></strong>
                                        <p>O fato de o coeficiente de correlação estar entre 0 e 0.4 indica uma correlação fraca.</p>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="list-group-item">O valor obtido é
                                        <strong><?php echo ($objTurma['percentualregresso']); ?></strong>
                                        <p>O fato de o coeficiente de correlação estar próximo de 0 indica ausência de correlação.</p>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="text-center mt-2 col-md-4">
                            <label for="resultados-negativos"><strong>Interpretações</strong></label>
                            <ul id="resultados-negativos" class="list-group">
                                <?php
                                if ($objTurma['percentualregresso'] < 0) {
                                ?>
                                    <li class="list-group-item">
                                        <p>Podemos analisar os dados da seguinte forma:
                                            Os alunos que faltaram menos tendem a obter notas mais altas,
                                            e aqueles que faltaram mais frequentemente tendem a obter notas mais baixas.</p>
                                    </li>
                                <?php
                                } elseif ($objTurma['percentualregresso'] > 0) {
                                ?>
                                    <li class="list-group-item">
                                        <p>Podemos analisar os dados da seguinte forma:
                                            Os alunos que faltaram menos tendem a obter notas mais altas,
                                            e aqueles que faltaram mais frequentemente tendem a obter notas mais baixas.</p>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="list-group-item">
                                        <p>Não há uma relação clara entre notas e faltas.
                                            Outros fatores podem estar envolvidos e influenciar essas variáveis.</p>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

            </body>
            </table>
        </div>

        <script>
    // Dados para o gráfico
    var notas = <?php echo json_encode($notas); ?>;
    var faltas = <?php echo json_encode($faltas); ?>;

    // Configuração do gráfico de dispersão
    var ctx = document.getElementById('scatterChart').getContext('2d');
    var scatterChart = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Notas e Faltas',
                data: Array.from({ length: notas.length }, (_, i) => ({ x: notas[i], y: faltas[i] })),
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Cor de fundo
                pointRadius: 5, // Tamanho dos pontos
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Notas'
                    }
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Faltas'
                    }
                }
            }
        }
    });
</script>
    </body>

    </html>
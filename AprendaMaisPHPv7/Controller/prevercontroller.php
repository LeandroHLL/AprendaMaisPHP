<?php
// caminho_para_prever_notas.php
require_once('../Model/previsao.php'); // Substitua pelo caminho correto

// Verifica se o ID da turma foi enviado via POST
if (isset($_POST['idturma'])) {
    $idturma = $_POST['idturma'];

    // Cria uma instância da classe Previsao
    $objPrevisao = new Previsao();

    // Chama a função preverNotas para a turma especificada
    $resultados = $objPrevisao->preverNotas($idturma);

    // Retorna os resultados (pode ser usado para exibir uma mensagem ou processar de outra forma no lado do cliente)
    echo $resultados;
} else {
    // Retorna uma mensagem de erro se o ID da turma não foi recebido
    echo 'Erro: ID da turma não fornecido.';
}
?>
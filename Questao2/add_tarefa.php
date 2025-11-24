<?php

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $vencimento = isset($_POST['vencimento']) ? trim($_POST['vencimento']) : '';

    if ($descricao === '' || $vencimento === '') {
        header("Location: index.php?msg=" . urlencode("Preencha todos os campos!"));
        exit;
    }

    $sql = "INSERT INTO tarefas (descricao, vencimento) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro no prepare: " . $conexao->error);
    }
    $stmt->bind_param("ss", $descricao, $vencimento);

    if ($stmt->execute()) {
        header("Location: index.php?msg=" . urlencode("Tarefa adicionada com sucesso!"));
        exit;
    } else {
        header("Location: index.php?msg=" . urlencode("Erro ao inserir: " . $conexao->error));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

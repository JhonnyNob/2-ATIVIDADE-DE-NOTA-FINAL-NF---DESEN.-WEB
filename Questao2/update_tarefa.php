<?php

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    $sql = "UPDATE tarefas SET concluida = 1 WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro no prepare: " . $conexao->error);
    }
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=" . urlencode("Tarefa marcada como concluída."));
        exit;
    } else {
        header("Location: index.php?msg=" . urlencode("Erro ao atualizar: " . $conexao->error));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

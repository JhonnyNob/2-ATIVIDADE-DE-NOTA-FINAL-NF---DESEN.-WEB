<?php

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    $sql = "DELETE FROM tarefas WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro no prepare: " . $conexao->error);
    }
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=" . urlencode("Tarefa excluída."));
        exit;
    } else {
        header("Location: index.php?msg=" . urlencode("Erro ao apagar: " . $conexao->error));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

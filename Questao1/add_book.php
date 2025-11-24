<?php
require_once "database.php";

if (isset($_POST["add_book"])) {

    $ID = $_POST["ID"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];

    $stmt = $conexao->prepare("INSERT INTO livros (ID, titulo, autor, ano) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $ID, $titulo, $autor, $ano);

    $stmt->execute();
}

header("Location: index.php");
exit;
?>

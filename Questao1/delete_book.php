<?php
require_once "database.php";

if (isset($_POST["delete_book"])) {

    $ID = $_POST["ID"];

    $stmt = $conexao->prepare("DELETE FROM livros WHERE ID = ?");
    $stmt->bind_param("i", $ID);

    $stmt->execute();
}

header("Location: index.php");
exit;
?>

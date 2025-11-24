<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "tarefas";

$con = new mysqli($host, $usuario, $senha);

if ($con->connect_error) {
    die("Falha na conexão: " . $con->connect_error);
}

if (!$con->select_db($banco)) {
    $createDbSql = "CREATE DATABASE IF NOT EXISTS `$banco` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!$con->query($createDbSql)) {
        die("Erro ao criar banco: " . $con->error);
    }
    $con->select_db($banco);
}

$tableSql = "CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT NOT NULL,
    vencimento DATE NOT NULL,
    concluida TINYINT(1) NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if (!$con->query($tableSql)) {
    die("Erro ao criar tabela: " . $con->error);
}

$conexao = $con;
?>

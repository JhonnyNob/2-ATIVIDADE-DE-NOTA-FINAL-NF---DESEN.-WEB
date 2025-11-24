<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "livraria";

// Conexão MySQL
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Criar tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS livros (
    ID INT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    ano INT NOT NULL
)";

$conexao->query($sql);

// Listar livros
$resultado = $conexao->query("SELECT * FROM livros ORDER BY ID ASC");
?>

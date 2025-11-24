<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Livraria</title>
</head>
<body>

<h1>Cadastro de Livros</h1>

<form method="post" action="add_book.php">
    <label>ID:</label><br>
    <input type="number" name="ID" required><br><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <label>Ano de Publicação:</label><br>
    <input type="number" name="ano" required><br><br>

    <button type="submit" name="add_book">Adicionar Livro</button>
</form>

<hr>

<h2>Excluir Livro</h2>
<form method="post" action="delete_book.php">
    <label>ID do Livro:</label><br>
    <input type="number" name="ID" required><br><br>
    <button type="submit" name="delete_book">Excluir</button>
</form>

<hr>

<h2>Livros Cadastrados</h2>

<?php
require_once "database.php";

if ($resultado->num_rows > 0) {
    echo "<ul>";
    while ($livro = $resultado->fetch_assoc()) {
        echo "<li>ID: {$livro['ID']} - {$livro['titulo']} ({$livro['autor']}), {$livro['ano']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum livro encontrado.</p>";
}
?>

</body>
</html>


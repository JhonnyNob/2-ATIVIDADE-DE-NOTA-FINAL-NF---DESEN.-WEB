<?php

include 'database.php';

$pendentes = $conexao->query("SELECT * FROM tarefas WHERE concluida = 0 ORDER BY vencimento");
$concluidas = $conexao->query("SELECT * FROM tarefas WHERE concluida = 1 ORDER BY vencimento");

$mensagemGeral = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Tarefas</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Playwrite+DE+SAS:wght@100..400&display=swap');
    body {
      font-family: "Playwrite DE SAS", cursive;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #331F19; 
    }
    .container {
      text-align: center;
      background-color: #CBBBA7;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 700px;
      border: 2px solid #8B7D70;
    }
    h1 {
      color: #331F19;
      margin: 0 0 6px 0;
    }
    p.lead {
      color: #331F19;
      font-size: 1.1em;
      margin: 6px 0 12px 0;
    }
    button {
      background-color: #60041A;
      color: #F4F0EA;
      padding: 8px 14px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.95em;
      transition: background-color 0.3s ease;
      margin-left: 6px;
    }
    button:hover { background-color: #A34743; }
    ul {
      list-style: none;
      padding: 0;
      margin-top: 12px;
    }
    ul li {
      background-color: #F4F0EA;
      color: #331F19;
      padding: 10px;
      margin: 6px 0;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .task-info { text-align: left; flex: 1; min-width: 200px; }
    .task-actions { white-space: nowrap; }
    input[type="text"], input[type="date"] {
      padding: 10px;
      width: calc(50% - 12px);
      max-width: 300px;
      margin-top: 10px;
      margin-bottom: 10px;
      border: 2px solid #8B7D70;
      border-radius: 5px;
      font-size: 1em;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
      transition: border-color 0.3s ease;
    }
    input[type="text"]:focus, input[type="date"]:focus {
      border-color: #60041A;
      box-shadow: inset 0 2px 4px rgba(96, 4, 26, 0.12);
      outline: none;
    }
    .mensagem {
      color: #331F19;
      margin-top: 8px;
      min-height: 20px;
    }
    .columns {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-top: 12px;
    }
    .column {
      text-align: left;
    }
    .column h3 { margin: 0 0 6px 0; color: #331F19; font-size: 1.05em; }
    .small-muted { font-size: 0.9em; color:#6b4f49; margin:0; }
    form.inline { display: inline; margin: 0; padding: 0; }
    .btn-link {
      background: none;
      border: none;
      color: #60041A;
      cursor: pointer;
      padding: 6px 8px;
      font-weight: 600;
      border-radius: 4px;
    }
    .btn-link:hover { background-color: rgba(96,4,26,0.08); }
    @media (max-width:600px){
      .columns { grid-template-columns: 1fr; }
      input[type="text"], input[type="date"] { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Gerador de lista de tarefas</h1>
    <p class="lead">Adicione suas tarefas!</p>

    <form action="add_tarefa.php" method="POST" style="display:flex; flex-wrap:wrap; justify-content:center; gap:8px; align-items:center;">
      <input type="text" name="descricao" id="inputTarefa" placeholder="Digite sua tarefinha" required>
      <input type="date" name="vencimento" required>
      <button type="submit">Adicionar Tarefa</button>
    </form>

    <p class="mensagem" id="mensagem"><?php echo $mensagemGeral ? $mensagemGeral : ''; ?></p>

    <div class="columns">
      <div class="column">
        <h3>Tarefas Pendentes</h3>
        <?php if ($pendentes && $pendentes->num_rows > 0): ?>
          <ul>
            <?php while ($t = $pendentes->fetch_assoc()): ?>
              <li>
                <div class="task-info">
                  <strong><?php echo htmlspecialchars($t['descricao']); ?></strong><br>
                  <span class="small-muted">Vence em: <?php echo htmlspecialchars(date('d/m/Y', strtotime($t['vencimento']))); ?></span>
                </div>
                <div class="task-actions">
                  <form class="inline" action="update_tarefa.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                    <button class="btn-link" type="submit" title="Marcar como concluída">Concluir</button>
                  </form>
                  <form class="inline" action="delete_tarefa.php" method="POST" onsubmit="return confirm('Excluir esta tarefa?');">
                    <input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                    <button class="btn-link" type="submit" title="Excluir tarefa">Excluir</button>
                  </form>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p>Não há tarefas pendentes.</p>
        <?php endif; ?>
      </div>

      <div class="column">
        <h3>Tarefas Concluídas</h3>
        <?php if ($concluidas && $concluidas->num_rows > 0): ?>
          <ul>
            <?php while ($t = $concluidas->fetch_assoc()): ?>
              <li>
                <div class="task-info">
                  <strong style="text-decoration: line-through;"><?php echo htmlspecialchars($t['descricao']); ?></strong><br>
                  <span class="small-muted">Concluída — Venceu em: <?php echo htmlspecialchars(date('d/m/Y', strtotime($t['vencimento']))); ?></span>
                </div>
                <div class="task-actions">
                  <form class="inline" action="delete_tarefa.php" method="POST" onsubmit="return confirm('Excluir esta tarefa concluída?');">
                    <input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                    <button class="btn-link" type="submit">Excluir</button>
                  </form>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p>Não há tarefas concluídas.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>

    (function(){
      const msg = document.getElementById('mensagem');
      if (msg && msg.textContent.trim() !== '') {
        setTimeout(()=>{ msg.textContent = ''; }, 4000);
      }
    })();
  </script>
</body>
</html>


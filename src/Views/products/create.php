<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .erro {
            color: red;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <h2>Cadastrar Produto</h2>

    <form action="index.php?action=store" method="post">
        
        <div class="campo">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($dados['nome'] ?? '') ?>">
            <?php if (isset($erros['nome'])): ?>
                <span class="erro"><?= $erros['nome'] ?></span>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?= htmlspecialchars($dados['preco'] ?? '') ?>">
            <?php if (isset($erros['preco'])): ?>
                <span class="erro"><?= $erros['preco'] ?></span>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="<?= htmlspecialchars($dados['quantidade'] ?? '') ?>">
            <?php if (isset($erros['quantidade'])): ?>
                <span class="erro"><?= $erros['quantidade'] ?></span>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
            <?php if (isset($erros['descricao'])): ?>
                <span class="erro"><?= $erros['descricao'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Salvar Produto</button>
        <a href="index.php">Cancelar</a>

    </form>

</body>
</html>
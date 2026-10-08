<?php
/** @var \App\Models\Product $produto */
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <form action="index.php?action=update" method="post">
    <input type="hidden" name="id" value="<?= $produto->getId() ?>">

    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($produto->getNome()) ?>" required>

    <label>Preço</label>
    <input type="number" name="preco" step="0.01" value="<?= $produto->getPreco() ?>" required>

    <label>Quantidade</label>
    <input type="number" name="quantidade" value="<?= $produto->getQuantidade() ?>" required>

    <label>Descrição</label>
    <input type="text" name="descricao" value="<?= htmlspecialchars($produto->getDescricao()) ?>" required> 

    <input type="submit" value="Salvar Alterações">
</form>
</body>
<style>
    body {
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }
    form {
        display: flex;
        align-items: center;
        flex-direction: column;
    }
</style>
</html>
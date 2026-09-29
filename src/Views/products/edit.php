<?php
/** @var Array $produto */
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
        <form action="index.php?action=store" method="post">
            <input type="hidden" name="id" value="<?= $produto[0]['id'] ?>">
        <label>Nome</label>
        <input type="text" name="nome" required value="<?= $produto[0]["nome"] ?>">
        <label>Descrição</label>
        <input type="text" name="descricao" required  value="<?= $produto[0]["descricao"] ?>">
        <label>Preço</label>
        <input type="number" name="preco" step="0.01" required value="<?= $produto[0]["preco"] ?>">
        <label>quantidade</label>
        <input type="number" name="quantidade" required value="<?= $produto[0]["quantidade"] ?>">
        <input type="submit" value="Editar">
    </form>
    </form>
</body>
<style>
    body{
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }
    form{
        display: flex;
        align-items: center;
        flex-direction: column;
    }
</style>
</html>
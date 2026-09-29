<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar</title>
</head>
<body>
    <form action="index.php?action=store" method="post">
        <label>Nome</label>
        <input type="text" name="nome" required >
        <label>Preço</label>
        <input type="number" name="preco" step="0.01" required >
        <label>quantidade</label>
        <input type="number" name="quantidade" required>
        <label>Descrição</label>
        <input type="text" name="descricao" required> 
        <input type="submit" value="Criar">
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
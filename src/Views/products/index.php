<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
</head>
<body>

    <h1>Lista de Produtos</h1>
    <a href="index.php?action=create">Adicionar Novo Produto</a>

    <!-- Formulário que envia a busca -->
    <form action="index.php" method="GET" style="margin-top: 15px;">
        <input type="hidden" name="action" value="search">
        <input type="text" name="termo" value="<?= htmlspecialchars($_GET['termo'] ?? '') ?>" placeholder="Buscar produtos...">
        <button type="submit">Buscar</button>
        <?php if (!empty($_GET['termo'])): ?>
            <a href="index.php?action=index">Ver Todos</a>
        <?php endif; ?>
    </form>

    <!-- ÚNICA TABELA DO SISTEMA -->
    <table border="1" cellpadding="8" style="margin-top: 15px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhum produto encontrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['quantidade']) ?></td>
                        <td><a href="index.php?action=edit&id=<?= $p['id'] ?>">Editar</a></td>
                        <td>
                            <a href="index.php?action=delete&id=<?= $p['id'] ?>" 
                               onclick="return confirm('Deseja excluir?');" 
                               style="color: red;">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
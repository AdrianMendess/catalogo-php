<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
</head>
<body>
    <h1>Lista de Produtos</h1>
    <a href="index.php?action=create">Adicionar Novo Produto</a>

    <table border="1" cellpadding="8" style="margin-top: 15px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr><td colspan="4">Nenhum produto cadastrado.</td></tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['quantidade']) ?></td>
                        <td><?= htmlspecialchars($p['descricao']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>